<div data-simplebar class="h-100">

    <!--- Sidemenu -->
    <div id="sidebar-menu">
        <!-- Left Menu Start -->
      <ul class="metismenu list-unstyled" id="side-menu">
    <li class="menu-title" key="t-menu">Menu</li>

        @if(Auth::user()->role=='super admin')
        {{-- LES MENUS DU SUPER ADMIN ICI --}}
    <li>
    <a href="{{ route('dashboard') }}" class="waves-effect">
        <i class="bx bx-home-circle"></i>
        <span>Tableau de bord</span>
    </a>
</li>
     
    <li>
    <a href="{{ route('formateur') }}" class="waves-effect">
        <i class="bx bx-user-voice"></i>
        <span>Formateur</span>
    </a>
</li>

<li>
    <a href="{{ route('etudiant') }}" class="waves-effect">
        <i class="bx bx-user"></i>
        <span>Étudiant</span>
    </a>
</li>

    <li>
    <a href="{{ route('formation') }}" class="waves-effect">
        <i class="bx bx-book-open"></i>
        <span>Formation</span>
    </a>
</li>

<li>
    <a href="{{ route('inscription') }}" class="waves-effect">
        <i class="bx bx-edit-alt"></i>
        <span>Inscription</span>
    </a>
</li>



    <li>
        <a href="{{ route('dons') }}" class="waves-effect">
            <i class="bx bx-photo-album"></i>
            <span key="t-chat">Dons</span>
        </a>
    </li>
    @elseif(Auth::user()->role=='etudiant')
    {{-- LES MENUS DE L'ETUDIANTS --}}
         <li>
    <a href="{{ route('dashboard') }}" class="waves-effect">
        <i class="bx bx-home-circle"></i>
        <span>Tableau de bord</span>
    </a>
</li>
<li>
    <a href="#" class="waves-effect">
        <i class="bx bx-edit-alt"></i>
        <span>Mes cours</span>
    </a>
</li>
@elseif(Auth::user()->role=='formateur')
{{-- LES MENUES DU FORMATEURS --}}
         <li>
    <a href="{{ route('dashboard') }}" class="waves-effect">
        <i class="bx bx-home-circle"></i>
        <span>Tableau de bord</span>
    </a>
</li>
<li>
    <a href="#" class="waves-effect">
        <i class="bx bx-edit-alt"></i>
        <span>Mes cours</span>
    </a>
</li>
        @endif

</ul>
    </div>
</div>