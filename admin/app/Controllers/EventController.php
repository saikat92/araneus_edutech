<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Models\EventModel;

class EventController extends Controller {
    private EventModel $model;
    public function __construct() { $this->requireAuth(); $this->model = new EventModel(); }

    public function index(): void {
        $events=$this->model->findAll('event_date DESC');
        $this->view('admin/events/index', compact('events')+['title'=>'Events']);
    }
    public function create(): void { $this->view('admin/events/form',['title'=>'New Event','event'=>null]); }
    public function store(): void {
        $this->model->create([
            'title'               => trim($this->post('title')),
            'description'         => trim($this->post('description')),
            'event_date'          => $this->post('event_date'),
            'event_time'          => $this->post('event_time'),
            'venue'               => trim($this->post('venue')),
            'event_type'          => $this->post('event_type','webinar'),
            'registration_link'   => trim($this->post('registration_link')),
            'is_upcoming'         => (int)$this->post('is_upcoming',1),
        ]);
        $this->setFlash('success','Event added.'); $this->redirect('/admin/events');
    }
    public function edit(string $id): void {
        $event=$this->model->findById((int)$id);
        $this->view('admin/events/form',compact('event')+['title'=>'Edit Event']);
    }
    public function update(string $id): void {
        $this->model->update((int)$id,[
            'title'             => trim($this->post('title')),
            'description'       => trim($this->post('description')),
            'event_date'        => $this->post('event_date'),
            'event_time'        => $this->post('event_time'),
            'venue'             => trim($this->post('venue')),
            'event_type'        => $this->post('event_type','webinar'),
            'registration_link' => trim($this->post('registration_link')),
            'is_upcoming'       => (int)$this->post('is_upcoming',1),
        ]);
        $this->setFlash('success','Event updated.'); $this->redirect('/admin/events');
    }
    public function delete(string $id): void {
        $this->model->delete((int)$id);
        $this->setFlash('success','Event deleted.'); $this->redirect('/admin/events');
    }
}
