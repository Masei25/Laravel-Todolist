<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use App\Models\Todolist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Tasks extends Component
{
    use AuthorizesRequests;
    
    public $task;
    
    public $task_id, $task_name, $date, $status;
    public $user;
    protected $listeners = ['refreshTask' => '$refresh'];

    public function render(Request $request)
    {
        $search = $request->search;

        $tasks = Todolist::query()
                ->when($search, function(Builder $query) use ($search){
                    $query->where('task_name', 'like', '%' . $search . '%');
                })
                ->where('user_id', Auth::user()->id)
                ->orderBy('status', 'desc')
                ->paginate(10)
                ->withQueryString();
        
        $users = User::all();
        
        return view('livewire.tasks', compact('tasks', 'users'));
    }

    protected function rules()
    {
        return [
            'task_name' => 'required|string',
            'date' => 'required|date',
            'user' => 'sometimes'
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function saveTask()
    {
        $validatedData = $this->validate();

        Todolist::create([
            'user_id' => Auth::user()->id,
            'task_name' => $validatedData['task_name'],
            'end_date' => $validatedData['date'],
        ]);

        session()->flash('message','Student Added Successfully');
        $this->resetInput();
        $this->emit('refreshTask');
        $this->dispatchBrowserEvent('close-modal');
    }

    public function editTask(int $task_id)
    {
        $task = Todolist::find($task_id);
        
        $this->task_id = $task->id;
        $this->task_name = $task->task_name;
        $this->date = $task->end_date;
        $this->user = $task->assigned_to;
        
        $this->emit('refreshTask');

    }

    public function updateTask()
    {
        $validatedData = $this->validate();
        $assigned = $this->user;
        is_array($assigned) ? $assigned = implode(", ", $assigned) : $assigned;

        Todolist::where('id', $this->task_id)->update([
            'task_name' => $validatedData['task_name'],
            'end_date' => $validatedData['date'],
            'assigned_to' => $assigned ?? 'Not Yet Assigned'
        ]);

        session()->flash('message','Task Updated Successfully');
        $this->resetInput();
        // $this->emit('refreshTask');
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
    
        $task->update([
            'status' => $this->status
        ]);

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

    public function resetInput() 
    {
        $this->task_name = '';
        $this->date = '';
    }

    public function close()
    {
        $this->resetInput();
    }

}
