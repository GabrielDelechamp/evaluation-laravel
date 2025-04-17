<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Gestion des Salles') }}
      </h2>
  </x-slot>


<x-button link="{{route('salle.create')}}">Ajouter</x-button>
<table>
  <thead>
    <tr>
      <th>Nom de la salle</th>
      <th>Capacité</th>
      <th>Surface</th>
    </tr>
  </thead>

  <tbody>
    @foreach ($salles as $salle)
    <tr>
      <td>{{$salle->name}}</td>
      <td>{{$salle->capacity}}</td>
      <td>{{$salle->surface}}</td>

      <td class='flex gap-2'>
        <x-button link="{{ route('salle.edit', ['salle' => $salle]) }}" class="bg-yellow-500">Éditer</x-button>
        <form method="post" action="{{ route('salle.destroy', ['salle' => $salle]) }}">
            @method('delete')
            @csrf
            <button type="submit" class="p-2 text-white bg-red-500 rounded-xl">Supprimer</button>
        </form>
      </td>
    </tr>

    @endforeach
  </tbody>
</table>


</x-app-layout>
