<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    @vite('resources/css/app.css') <!-- Untuk Tailwind CSS -->
</head>
<body class="bg-gray-100 flex justify-center items-center min-h-screen">
    <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-md">
        <h1 class="text-2xl font-bold mb-4">To-Do List</h1>
        
        <!-- Form untuk Menambah Task -->
        <form action="/tasks" method="POST" class="flex flex-col gap-2 mb-4">
            @csrf
            <input 
                type="text" 
                name="title" 
                placeholder="Add a task" 
                class="p-2 border rounded" 
                required>
            <input 
                type="date" 
                name="deadline" 
                class="p-2 border rounded">
            <button 
                type="submit" 
                class="bg-blue-500 text-white px-4 py-2 rounded">
                Add
            </button>
        </form>
        

        <!-- Daftar Task -->
        <ul class="space-y-2">
            @foreach($tasks as $task)
            @php
                $today = \Carbon\Carbon::today();
                $deadline = $task->deadline ? \Carbon\Carbon::parse($task->deadline) : null;
                $bgColor = $deadline
                    ? ($deadline->isPast() ? 'bg-red-100' : ($deadline->isToday() ? 'bg-yellow-100' : 'bg-green-100'))
                    : 'bg-gray-100';
            @endphp
            <li class="flex justify-between items-center p-2 border rounded {{ $bgColor }}">
                <div class="flex items-center gap-2">
                    <form action="/tasks/{{ $task->id }}" method="POST" class="inline">
                        @method('PUT')
                        @csrf
                        <input 
                            type="checkbox" 
                            name="is_completed" 
                            onchange="this.form.submit()" 
                            {{ $task->is_completed ? 'checked' : '' }}>
                    </form>
                    <span class="{{ $task->is_completed ? 'line-through text-gray-500' : '' }}">
                        {{ $task->title }}
                    </span>
                    @if($task->deadline)
                    <span class="text-sm text-gray-700">({{ $task->deadline }})</span>
                    @endif
                </div>
                <form action="/tasks/{{ $task->id }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button class="text-red-500">Delete</button>
                </form>
            </li>
            @endforeach
        </ul>
    </div>
</body>
</html>
