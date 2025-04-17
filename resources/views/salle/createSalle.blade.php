<x-app-layout>
  <form action="{{route('salle.store')}}" method='post'>
      @csrf
      @method('post')
      <label for="name" class="">Nom</label>
      <input type="text" name="name">
      <label for="capacity" class="">Capacité</label>
      <input type="number" name="capacity">
      <label for="surface" class="">Surface</label>
      <input type="number" name="surface">

      <button type="submit" class="">Envoyer</button>
  </form>
</x-app-layout>
