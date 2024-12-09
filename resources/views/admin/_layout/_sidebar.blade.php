<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <div class="sb-sidenav-menu-heading">Admin</div>
                    <a class="nav-link" href="{{route('admin.index')}}">
                        <div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>
                        Homepage
                    </a>
                    
                    <a class="nav-link" href="{{route('admin.post.index')}}">
                        <div class="sb-nav-link-icon"><i class="fas fa-file-alt"></i></div>
                        Posts
                    </a>
                    
                    <a class="nav-link" href="{{route('admin.category.index')}}">
                        <div class="sb-nav-link-icon"><i class="fas fa-th-list"></i></div>
                        Categories
                    </a>
                    
                    <a class="nav-link" href="{{route('admin.tag.index')}}">
                        <div class="sb-nav-link-icon"><i class="fas fa-tag"></i></div>
                        Tags
                    </a>
                    
                    <a class="nav-link" href="{{route('admin.author.index')}}">
                        <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                        Authors
                    </a>
                    
                    <a class="nav-link" href="{{route('admin.profile')}}">
                        <div class="sb-nav-link-icon"><i class="fas fa-user-circle"></i></div>
                        Profile
                    </a>

                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    {{auth()->user()->name}}
                </div>
        </nav>
    </div>