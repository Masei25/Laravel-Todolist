<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Todolist;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Tasks extends Component
{
    use AuthorizesRequests;
    
    public $task;
    
    public $task_id, $task_name, $description, $status;
    public $selectedTask = [];

    protected function rules()
    {
        return [
            'task_name' => 'required|string',
            'description' => 'required|string',
        ];
    }

    public function mount()
    {
        $this->task = new Todolist();
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function saveTask()
    {
        $validatedData = $this->validate();

        Todolist::create($validatedData);

        session()->flash('message','Student Added Successfully');
        $this->reset();
        $this->dispatchBrowserEvent('close-modal');
    }

    public function editTask(int $task_id)
    {
        $task = Todolist::find($task_id);
        
        $this->task_id = $task->id;
        $this->task_name = $task->task_name;
        $this->description = $task->description;

    }

    public function updateTask()
    {
        $validatedData = $this->validate();

        Todolist::where('id', $this->task_id)->update([
            'task_name' => $validatedData['task_name'],
            'description' => $validatedData['description']
        ]);

        session()->flash('message','Task Updated Successfully');
        $this->reset();
        $this->dispatchBrowserEvent('close-modal');
    }

    public function delete(int $task_id) 
    {
        $this->task_id = $task_id;
    }

    public function destroyTask()
    {
        $task = Todolist::find($this->task_id);

        $task->delete();

        session()->flash('message','Task Deleted');
        $this->reset();
        $this->dispatchBrowserEvent('close-modal');
    }

    public function toggleStatus(int $task_id)
    {
        $task = Todolist::find($task_id);
        $this->status = $task->status;

        ($task->status === $task->isPending() ? 
            $this->status = $task->inProgress() : 
                $this->status = $task->isPending());
    
        Todolist::where('id', $task_id)->update([
            'status' => $this->status
        ]);

        $this->reset();

    }

    public function completed(int $task_id)
    {
        $task = Todolist::find($task_id);
        $this->status = $task->status;

        ($task->status != $task->isCompleted() ? 
            $this->status = $task->isCompleted() : 
                $this->status = $task->inProgress());

        Todolist::where('id', $task_id)->update([
            'status' => $this->status
        ]);

        $this->reset();
    }

    public function render()
    {
        $tasks = Todolist::orderBy('status', 'DESC')->paginate(15);
       
        return view('livewire.tasks', ['tasks' => $tasks]);
    }
}
