<x-app-layout>
    <section class="bg-white dark:bg-gray-900">
        <div class="grid max-w-screen-xl px-4 pt-20 pb-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12 lg:pt-28">
            <div class="grid col-span-full">
                <h1 class="mb-5">{{ __('task.editTask') }}</h1>

                <form class="w-50" method="POST" action="{{ route('task.update', ['task' => $task]) }}">
                    @csrf
                    @method('patch')
                    <div class="flex flex-col">
                        <div>
                            <label for="name">{{ __('task.name') }}</label>
                        </div>
                        <div class="mt-2">
                            <input class="rounded border-gray-300 w-1/3" type="text" name="name" id="name" value="{{ $task->name }}">
                        </div>
                        <div class="mt-2">
                            <label for="description">{{ __('task.description') }}</label>
                        </div>
                        <div>
                            <textarea class="rounded border-gray-300 w-1/3 h-32" name="description" id="description">{{ $task->description }}</textarea>
                        </div>
                        <div class="mt-2">
                            <label for="status_id">{{ __('task.status') }}</label>
                        </div>
                        <div>
                            <select class="rounded border-gray-300 w-1/3" name="status_id" id="status_id">
                                @foreach($task_statuses as $status)
                                    <option
                                        value="{{ $status->id }}"
                                        @if ($status->id === $task->status->id)
                                            selected="selected"
                                        @endif
                                    >
                                        {{ $status->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-2">
                            <label for="status_id">{{ __('task.executor') }}</label>
                        </div>
                        <div>
                            <select class="rounded border-gray-300 w-1/3" name="assigned_to_id" id="assigned_to_id">
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}"
                                            @if ($user->id === $task->executer->id)
                                            selected="selected"
                                        @endif
                                    >
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-2">
                            <label for="status_id">{{ __('task.tags') }}</label>
                        </div>
                        <div>
                            <select class="rounded border-gray-300 w-1/3 h-32" name="labels[]" id="labels[]" multiple><option value="1">ошибка</option><option value="2">документация</option><option value="3">дубликат</option><option value="4">доработка</option></select>
                        </div>
                        <div class="mt-2">
                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" type="submit">{{ __('task.edit') }}</button>
                        </div>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </section>
</x-app-layout>
