<x-app-layout>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="csrf-param" content="_token" />
    <section class="bg-white dark:bg-gray-900">
        <div class="grid max-w-screen-xl px-4 pt-20 pb-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12 lg:pt-28">
            <div class="grid col-span-full">
                <h1 class="mb-5">{{ __('task.tasks') }}</h1>
                @if (Auth::check())
                    <div>
                        <a href="{{ route('task.build') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ms-3">
                            {{ __('task.createTask') }}
                        </a>
                    </div>
                @endif
                <table class="mt-4">
                    <thead class="border-b-2 border-solid border-black text-left">
                    <tr>
                        <th>{{ __('task.id') }}</th>
                        <th>{{ __('task.status') }}</th>
                        <th>{{ __('task.name') }}</th>
                        <th>{{ __('task.author') }}</th>
                        <th>{{ __('task.executor') }}</th>
                        <th>{{ __('task.dateCreate') }}</th>
                        @if (Auth::check())
                            <th>{{ __('task_status.actions') }}</th>
                        @endif
                    </tr>
                    </thead>
                    @foreach($tasks as $task)
                        <tr class="border-b border-dashed text-left">
                            <td>{{ $task->id }}</td>
                            <td>{{ $task->status->name }}</td>
                            <td>
                                <a
                                    class="text-blue-600 hover:text-blue-900"
                                    href="{{ route('task.show', ['task' => $task]) }}">
                                    {{ $task->name }}
                                </a>
                            </td>
                            <td>{{ $task->creator->name }}</td>
                            <td>{{ $task->executer->name }}</td>
                            <td>{{ $task->created_at }}</td>

                                <td>
                                    @if (Auth::id() === $task->creator->id)
                                    <a
                                        data-confirm="Вы уверены?"
                                        data-method="delete"
                                        class="text-red-600 hover:text-red-900"
                                        href="{{ route('task.destroy', ['task' => $task]) }}">
                                        {{ __('task.delete') }}
                                    </a>
                                    @endif
                            @if (Auth::check())
                                    <a class="text-blue-600 hover:text-blue-900" href="{{ route('task.edit', ['task' => $task]) }}">
                                        {{ __('task_status.edit') }}
                                    </a>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </section>
</x-app-layout>
