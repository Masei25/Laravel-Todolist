<?php

namespace App\Http\Livewire;

use Livewire\Component;

class EditTask extends Component
{
    public $task;

    public $task_name, $description;

    protected function rules()
    {
        return [
            'task_name' => 'required|string',
            'description' => 'required|string',
            'task.id' => 'required|string|unique:App\Models\Todolist,id,'.$this->task->id,
        ];
    }

    

    public function render()
    {
        return view('livewire.edit-task');
    }
}
