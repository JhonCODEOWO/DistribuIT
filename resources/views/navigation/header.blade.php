<div class="navbar bg-base-300 shadow-sm">
  <div class="flex-1">
    <a class="text-xl font-black ml-4">CakeShop</a>
  </div>
  <div class="flex gap-2 items-center pr-5">
    <div class="dropdown dropdown-end">
      <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
        <div class="w-10 rounded-full">
          <img alt="{{auth()->user()->name}}"
            src="{{asset('storage/'.auth()->user()->profile_picture)}}" loading="eager"/>
        </div>
      </div>
      <ul tabindex="0" class="menu menu-sm dropdown-content bg-base-100 rounded-box z-1 mt-3 w-52 p-2 shadow">
        <li>
          <a class="justify-between">
            Perfil
          </a>
        </li>
        <li><a>Ajustes</a></li>
        <li>
          <form action="{{route('auth.logout')}}" method="post">
            @csrf
            @method('delete')
            <button>Cerrar sesión</button>
          </form>
        </li>
      </ul>
    </div>
  </div>
</div>
