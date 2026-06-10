import qrcode
from PIL import Image, ImageDraw, ImageOps
import os
import requests
import math

# ─────────────────────────────────────────────
#  CONFIG  (tweak these to taste)
# ─────────────────────────────────────────────
QR_COLOR        = "#291F03"   # module (dot) colour
QR_BG_COLOR     = "white"     # background colour
QR_BOX_SIZE     = 18          # pixels per QR module
QR_BORDER       = 2           # quiet-zone modules
QR_CORNER_RADIUS= 80          # outer rounded-corner radius (px, after 2× upscale)

# Logo island
LOGO_FRACTION   = 0.28        # logo island = 28 % of QR side  (max ~30 % for H-correction)
LOGO_PADDING    = 18          # white padding around the logo inside the circle (px)
LOGO_BORDER_W   = 5           # coloured ring around the logo circle (px)
LOGO_BORDER_CLR = QR_COLOR    # ring colour  (set "" to disable)
# ─────────────────────────────────────────────


def create_rounded_qr(url: str,
                      logo_path: str | None = None,
                      output_path: str = "qrcode.png") -> Image.Image:
    """Generate a styled QR code with an optional centred logo island."""

    # ── 1. Build raw QR ──────────────────────────────────────────────────────
    qr = qrcode.QRCode(
        version=5,
        error_correction=qrcode.constants.ERROR_CORRECT_H,   # 30 % recovery
        box_size=QR_BOX_SIZE,
        border=QR_BORDER,
    )
    qr.add_data(url)
    qr.make(fit=True)

    qr_img = qr.make_image(fill_color=QR_COLOR, back_color=QR_BG_COLOR).convert("RGBA")

    # 2× upscale for crispness
    w, h = qr_img.size
    qr_img = qr_img.resize((w * 2, h * 2), Image.Resampling.LANCZOS)

    # ── 2. Rounded outer corners ─────────────────────────────────────────────
    qr_img = _add_rounded_corners(qr_img, radius=QR_CORNER_RADIUS)

    # ── 3. Centre logo island ────────────────────────────────────────────────
    if logo_path and os.path.exists(logo_path):
        try:
            qr_img = _embed_logo(qr_img, logo_path)
        except Exception as exc:
            print(f"⚠  Logo skipped: {exc}")
    elif logo_path:
        print(f"⚠  Logo file not found: {logo_path}  — skipping.")

    # ── 4. Save ───────────────────────────────────────────────────────────────
    final = qr_img
    if output_path.lower().endswith((".jpg", ".jpeg")):
        final = qr_img.convert("RGB")

    final.save(output_path, quality=95)
    print(f"✅  Saved → {output_path}  ({final.size[0]}×{final.size[1]} px)")
    return final


# ─── helpers ──────────────────────────────────────────────────────────────────

def _add_rounded_corners(img: Image.Image, radius: int) -> Image.Image:
    mask = Image.new("L", img.size, 0)
    ImageDraw.Draw(mask).rounded_rectangle([(0, 0), img.size], radius=radius, fill=255)
    result = Image.new("RGBA", img.size, (255, 255, 255, 0))
    result.paste(img, mask=mask)
    return result


def _embed_logo(qr_img: Image.Image, logo_path: str) -> Image.Image:
    """
    Carve a white circular island in the centre of the QR code and
    place the logo inside it — logo is always LARGER than the QR pattern.
    """
    qr_w, qr_h = qr_img.size
    side = min(qr_w, qr_h)

    # ── island geometry ───────────────────────────────────────────────────────
    island_r   = int(side * LOGO_FRACTION / 2)          # radius of white circle
    island_dia = island_r * 2
    cx, cy     = qr_w // 2, qr_h // 2

    # ── open & fit logo ───────────────────────────────────────────────────────
    logo = Image.open(logo_path).convert("RGBA")
    logo_max = island_dia - LOGO_PADDING * 2             # logo fits inside padding
    logo.thumbnail((logo_max, logo_max), Image.Resampling.LANCZOS)
    lw, lh = logo.size

    # ── build the circular island (white disc) ────────────────────────────────
    island_size = (island_dia, island_dia)
    island = Image.new("RGBA", island_size, (255, 255, 255, 0))

    # white fill circle
    disc_mask = Image.new("L", island_size, 0)
    ImageDraw.Draw(disc_mask).ellipse([(0, 0), (island_dia - 1, island_dia - 1)], fill=255)

    white_disc = Image.new("RGBA", island_size, (255, 255, 255, 255))
    island.paste(white_disc, mask=disc_mask)

    # coloured border ring
    if LOGO_BORDER_CLR and LOGO_BORDER_W > 0:
        ring_layer = Image.new("RGBA", island_size, (255, 255, 255, 0))
        ring_draw  = ImageDraw.Draw(ring_layer)
        bw = LOGO_BORDER_W
        # outer ring
        ring_draw.ellipse([(0, 0), (island_dia - 1, island_dia - 1)],
                          outline=LOGO_BORDER_CLR, width=bw)
        island = Image.alpha_composite(island, ring_layer)

    # paste logo centred on island
    lx = (island_dia - lw) // 2
    ly = (island_dia - lh) // 2
    island.paste(logo, (lx, ly), logo)

    # ── composite island onto QR ──────────────────────────────────────────────
    result = qr_img.copy()
    paste_x = cx - island_r
    paste_y = cy - island_r

    # use the disc mask to punch a clean hole + paste island
    hole_layer = Image.new("RGBA", qr_img.size, (255, 255, 255, 0))
    hole_layer.paste(island, (paste_x, paste_y))
    result = Image.alpha_composite(result, hole_layer)

    return result


def download_logo(url: str, save_path: str = "logo.png") -> str | None:
    try:
        r = requests.get(url, timeout=10)
        r.raise_for_status()
        with open(save_path, "wb") as f:
            f.write(r.content)
        print(f"✅  Logo downloaded → {save_path}")
        return save_path
    except Exception as exc:
        print(f"❌  Download failed: {exc}")
    return None


# ─── CLI ──────────────────────────────────────────────────────────────────────

def main():
    print("=" * 58)
    print("  🎨  QR Code Generator  —  Logo-Centred Edition")
    print("=" * 58)

    # URL
    url = input("\n🌐  URL to encode: ").strip()
    if not url:
        print("❌  URL is required."); return
    if not url.startswith(("http://", "https://")):
        print("⚠   URL looks incomplete.")
        if input("   Add https:// ? (y/n): ").strip().lower() in ("y", "yes"):
            url = "https://" + url
            print(f"   → {url}")

    # Logo
    logo_path = None
    if input("\n🖼   Add a logo? (y/n): ").strip().lower() in ("y", "yes"):
        src = input("   1 = local path   2 = URL\n   Choice: ").strip()
        if src == "1":
            p = input("   Logo path: ").strip()
            logo_path = p if os.path.exists(p) else (print(f"❌  Not found: {p}"), None)[1]
        elif src == "2":
            logo_path = download_logo(input("   Logo URL: ").strip())
        else:
            print("⚠   Unrecognised choice — no logo.")

    # Output
    default = "qrcode_logo.png" if logo_path else "qrcode.png"
    out = input(f"\n💾  Output filename [{default}]: ").strip() or default
    if not out.lower().endswith((".png", ".jpg", ".jpeg")):
        out += ".png"

    # Generate
    print(f"\n⚙   Generating …")
    try:
        img = create_rounded_qr(url, logo_path, out)
        print("\n" + "=" * 58)
        print(f"   File : {out}")
        print(f"   Size : {img.size[0]}×{img.size[1]} px")
        print(f"   URL  : {url}")
        print("=" * 58)
        if input("\n👀  Preview? (y/n): ").strip().lower() in ("y", "yes"):
            img.show()
    except Exception as exc:
        print(f"❌  {exc}")


if __name__ == "__main__":
    try:
        import qrcode
        from PIL import Image
    except ImportError:
        import subprocess, sys
        subprocess.check_call([sys.executable, "-m", "pip", "install",
                               "qrcode[pil]", "pillow", "requests"])
        print("✅  Packages installed — please run the script again.")
        raise SystemExit(0)

    try:
        main()
    except KeyboardInterrupt:
        print("\n\n👋  Cancelled.")