<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Login</title>
  @vite('resources/css/app.css')
</head>

<body>
  <div class="hero bg-base-200 min-h-screen">
    <div class=" w-[50vh]">
      <div class="card bg-base-100 w-full max-w-sm shrink-0 shadow-2xl">
        <div class="card-body">
          <h1 class=" font-black text-3xl">Iniciar sesión</h1>
          @error('error')
              <p class="text-error">{{$message}}</p>
          @enderror
          <form action="{{route('auth.login')}}" method="post">
            @csrf
            <fieldset class="fieldset">
            <label class="label">Email</label>
            <input type="email" class="input" placeholder="Email" name="email"/>
            @error('email')
                <p class="text-error">{{$message}}</p>
            @enderror
            <label class="label">Password</label>
            <input type="password" class="input" placeholder="Password" name="password"/>
            @error('password')
                <p class="text-error">{{$message}}</p>
            @enderror
            <div><a class="link link-hover">Forgot password?</a></div>
            <button class="btn btn-neutral mt-4">Login</button>
          </fieldset>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>

</html>
