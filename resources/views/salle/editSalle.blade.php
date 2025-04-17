<x-app-layout>
  <form action="{{route('salle.update', ['salle'=>$salle])}}" method='post'>
      @csrf
      @method('put')
      <label for="name" class="">Nom</label>
      <input type="text" name="name" value="{{old('name', $salle->name)}}">
      <label for="capacity" class="">Capacité</label>
      <input type="number" name="capacity" value="{{old('capacity', $salle->capacity)}}">
      <label for="surface" class="">Surface</label>
      <input type="number" name="surface" value="{{old('surface', $salle->surface)}}">

      <button type="submit" class="">Envoyer</button>
  </form>
</x-app-layout>
