<div class="flex gap-x-7">
  <fieldset class="flex gap-x-3 mb-2 items-center">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-[3rem]"><path fill="currentColor" d="m19.6 21l-6.3-6.3q-.75.6-1.725.95T9.5 16q-2.725 0-4.612-1.888T3 9.5t1.888-4.612T9.5 3t4.613 1.888T16 9.5q0 1.1-.35 2.075T14.7 13.3l6.3 6.3zM9.5 14q1.875 0 3.188-1.312T14 9.5t-1.312-3.187T9.5 5T6.313 6.313T5 9.5t1.313 3.188T9.5 14"/></svg>
    <input type="text" wire:model="searchQuery" class="input focus:input-success">
    <button class="btn btn-success" wire:click="search()">Buscar</button>
  </fieldset>

  @if ($searchQuery != '')
    <div>
      <p class="font-bold text-xl">Mostrando resultados de: {{ $searchQuery }}</p>
    </div>
  @endif
</div>
