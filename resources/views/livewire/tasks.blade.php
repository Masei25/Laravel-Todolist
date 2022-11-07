<div class="flex flex-col mt-4">
    <div>
        <form>
            @csrf
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:p b-4">

                <input name="search" type="text" value="{{request()->search ?? ''}}" class="w-1/2 bg-gray-100 p-2 mt-2 mb-3" placeholder="Search For Task"
                    required />
                <button type="submit" class="py-2 px-4 bg-blue-500 text-white rounded hover:bg-blue-700 mr-2"><i
                        class="fas fa-plus"></i> Search </button>
            </div>
        </form>

    </div>
    <div class="py-2 my-2 overflow-x-auto sm:-mx-6 sm:px-2 lg:-mx-8 lg:px-8">
        @if (session()->has('message'))
            <h4 class="text-green-600 flex justify-center mb-4"> {{ session()->get('message') }} </h4>
        @endif

        <div class="inline-block min-w-full overflow-hidden align-middle border-b border-gray-100 shadow sm:rounded-lg">
            <table class="min-w-full">
                <thead>
                    <tr>
                        <th>

                        </th>
                        <th
                            class="px-2 py-3 border-r text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-100 bg-gray-50">
                            Task</th>

                        <th
                            class="px-2 py-3 border-r text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-100 bg-gray-50">
                            End Date </th>
                        <th
                            class="px-2 py-3 border-r text-xs font-medium leading-4 tracking-wider text-center text-gray-500 uppercase border-b border-gray-100 bg-gray-50">
                            Status </th>
                        <th
                            class="px-2 py-3 border-r text-xs font-medium leading-4 tracking-wider text-center text-gray-500 uppercase border-b border-gray-100 bg-gray-50">
                            Assigned To </th>

                        <th
                            class="px-2 py-3 border-r text-xs text-center font-medium leading-4 tracking-wider text-gray-500 uppercase border-b border-gray-100 bg-gray-50">
                            Action </th>
                    </tr>
                </thead>

                <tbody class="bg-white">
                    @foreach ($tasks as $task)
                        <tr class="even:bg-gray-200 hover:bg-gray-300">

                            <td class="px-2 border-r whitespace-no-wrap border-b text-center border-gray-100">
                                <div class="text-sm leading-5 text-gray-500">
                                    <input type="checkbox" class="cursor-pointer"
                                        wire:click="completed({{ $task->id }})" @checked($task->status == 'COMPLETED')>
                                </div>
                            </td>

                            <td class="py-2 px-2 border-r whitespace-no-wrap border-b border-gray-100">
                                <div class="text-sm leading-5 text-gray-500">
                                    {{ $task->task_name ?? '' }}
                                </div>
                            </td>

                            <td class="py-2 px-2 border-r whitespace-no-wrap border-b border-gray-100">
                                {{ date('d-m-Y', strtotime($task->end_date)) ?? '' }}
                            </td>

                            @if ($task->status == 'COMPLETED')
                                <td
                                    class="py-2 px-2 border-r text-white flex items-center justify-evenly bg-green-600 whitespace-no-wrap border-b border-gray-100">
                                    {{ $task->status ?? '' }}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-emoji-heart-eyes" viewBox="0 0 16 16">
                                        <path
                                            d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                        <path
                                            d="M11.315 10.014a.5.5 0 0 1 .548.736A4.498 4.498 0 0 1 7.965 13a4.498 4.498 0 0 1-3.898-2.25.5.5 0 0 1 .548-.736h.005l.017.005.067.015.252.055c.215.046.515.108.857.169.693.124 1.522.242 2.152.242.63 0 1.46-.118 2.152-.242a26.58 26.58 0 0 0 1.109-.224l.067-.015.017-.004.005-.002zM4.756 4.566c.763-1.424 4.02-.12.952 3.434-4.496-1.596-2.35-4.298-.952-3.434zm6.488 0c1.398-.864 3.544 1.838-.952 3.434-3.067-3.554.19-4.858.952-3.434z" />
                                    </svg>
                                </td>
                            @elseif($task->status == 'IN PROGRESS')
                                <td
                                    class="py-2 px-2 border-r text-white flex items-center justify-evenly bg-yellow-600 whitespace-no-wrap border-b border-gray-100">
                                    {{ $task->status ?? '' }}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-emoji-neutral" viewBox="0 0 16 16">
                                        <path
                                            d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                        <path
                                            d="M4 10.5a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 0-1h-7a.5.5 0 0 0-.5.5zm3-4C7 5.672 6.552 5 6 5s-1 .672-1 1.5S5.448 8 6 8s1-.672 1-1.5zm4 0c0-.828-.448-1.5-1-1.5s-1 .672-1 1.5S9.448 8 10 8s1-.672 1-1.5z" />
                                    </svg>
                                </td>
                            @else
                                <td
                                    class="py-2 px-2 border-r text-white flex items-center justify-evenly bg-gray-600 whitespace-no-wrap border-b border-gray-100">
                                    {{ $task->status ?? '' }}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-emoji-frown" viewBox="0 0 16 16">
                                        <path
                                            d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                        <path
                                            d="M4.285 12.433a.5.5 0 0 0 .683-.183A3.498 3.498 0 0 1 8 10.5c1.295 0 2.426.703 3.032 1.75a.5.5 0 0 0 .866-.5A4.498 4.498 0 0 0 8 9.5a4.5 4.5 0 0 0-3.898 2.25.5.5 0 0 0 .183.683zM7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.448 5 6 5s1 .672 1 1.5zm4 0c0 .828-.448 1.5-1 1.5s-1-.672-1-1.5S9.448 5 10 5s1 .672 1 1.5z" />
                                    </svg>
                                </td>
                            @endif

                            <td class="py-2 px-2 border-r whitespace-no-wrap border-b text-center border-gray-100">
                                {{$task->assigned_to ?? 'Not Yet Assigned'}}
                            </td>

                            <td
                                class="text-sm py-2 px-2 border-r leading-5 text-gray-500 whitespace-no-wrap border-b border-gray-100">
                                <div class="flex justify-evenly">
                                    <button type="button" wire:click="toggleStatus({{ $task->id }})">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-clock cursor-pointer" viewBox="0 0 16 16">
                                            <path
                                                d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z" />
                                            <path
                                                d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z" />
                                        </svg>
                                    </button>

                                    <button type="button" wire:click="editTask({{ $task->id }})"
                                        data-bs-toggle="modal" data-bs-target="#editTaskModal">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-card-text cursor-pointer"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z" />
                                            <path
                                                d="M3 5.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM3 8a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 3 8zm0 2.5a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5z" />
                                        </svg>
                                    </button>


                                    <a href="{{ route('task.delete', $task->id) }}"
                                        onclick="return confirm('are you sure you want to delete this task?')">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-trash cursor-pointer" viewBox="0 0 16 16">
                                            <path
                                                d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                            <path fill-rule="evenodd"
                                                d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>


        <div class="col-12 mt-10">
            <div class="text-center">
                <ul class="">
                    {{ $tasks->links() }}
                </ul>
            </div>
        </div>

    </div>

    {{-- Add Task Modal --}}
    <div wire:ignore.self class="modal fade" id="addTaskModal" tabindex="-1" aria-labelledby="addTaskModal"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteStudentModalLabel">Add Task</h5>
                </div>
                <form wire:submit.prevent="saveTask">
                    @csrf
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <label>Task</label>
                        <input name="task_name" type="text" class="w-full bg-gray-100 p-2 mt-2 mb-3"
                            wire:model="task_name" />
                        @if ($errors->has('task_name'))
                            <small class="form-control-feedback" style="color:red">
                                {{ $errors->first('task_name') }}
                            </small>
                        @endif
                        <label>Due Date</label>
                        <input name="date" type="date" class="w-full bg-gray-100 p-2 mt-2 mb-3"
                            wire:model="date" />
                        @if ($errors->has('date'))
                            <small class="form-control-feedback" style="color:red">
                                {{ $errors->first('date') }}
                            </small>
                        @endif
                    </div>
                    <div class="px-4 py-3 text-right">
                        <button type="button" class="py-2 px-4 bg-gray-500 text-white rounded hover:bg-gray-700 mr-2"
                            data-bs-dismiss="modal"><i class="fas fa-times"></i>
                            Cancel</button>
                        <button class="py-2 px-4 bg-blue-500 text-white rounded hover:bg-blue-700 mr-2"><i
                                class="fas fa-plus"></i> Add </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Edit Task Modal --}}
    <div wire:ignore.self class="modal fade" id="editTaskModal" tabindex="-1" aria-labelledby="editTaskModal"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTaskModal">Edit Task</h5>
                </div>
                <form wire:submit.prevent="updateTask">
                    @csrf
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <label>Task</label>
                        <input name="task_name" type="text" class="w-full bg-gray-100 p-2 mt-2 mb-3"
                            wire:model="task_name" />
                        <label>Due Date</label>
                        <input name="date" type="date" class="w-full bg-gray-100 p-2 mt-2 mb-3"
                            wire:model="date" />
                        <label>Assign Task</label>
                        <select multiple wire:model="user" id="user" class="form-control">
                            @foreach ($users as $key => $value)
                                <option value="{{ $value->name }}" wire:key="item-{{ $key }}">
                                    {{ $value->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="px-4 py-3 text-right">
                        <button type="button" class="py-2 px-4 bg-gray-500 text-white rounded hover:bg-gray-700 mr-2"
                            data-bs-dismiss="modal"><i class="fas fa-times"></i>
                            Cancel</button>
                        <button class="py-2 px-4 bg-blue-500 text-white rounded hover:bg-blue-700 mr-2"><i
                                class="fas fa-plus"></i> Update </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Delete Task Modal --}}
    <div wire:ignore.self class="modal fade" id="deleteTaskModal" tabindex="-1" aria-labelledby="deleteTaskModal"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteTaskModal">Are you sure you want to delete this task ?</h5>
                </div>
                <form wire:submit.prevent="destroyTask">
                    @csrf

                    <div class="px-4 py-3 text-right">
                        <button type="button" class="py-2 px-4 bg-gray-500 text-white rounded hover:bg-gray-700 mr-2"
                            data-bs-dismiss="modal"><i class="fas fa-times"></i>
                            Cancel</button>
                        <button class="py-2 px-4 bg-blue-500 text-white rounded hover:bg-blue-700 mr-2"><i
                                class="fas fa-plus"></i> Confirm </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
