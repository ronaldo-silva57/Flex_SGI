<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Papéis e Permissões - {{ $usuario->name }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <form action="{{ route('roles.update', $usuario->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Papéis</label>
                    @foreach($roles as $role)
                        <div>
                            <input type="checkbox" name="roles[]" value="{{ $role->name }}"
                                   {{ $usuario->hasRole($role->name) ? 'checked' : '' }}>
                            <span>{{ $role->name }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Permissões</label>
                    @foreach($permissions as $permission)
                        <div>
                            <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                   {{ $usuario->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                            <span>{{ $permission->name }}</span>
                        </div>
                    @endforeach
                </div>

                <button type="submit" 
                        class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                    Salvar
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
