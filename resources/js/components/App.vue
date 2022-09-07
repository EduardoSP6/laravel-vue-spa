<template>
    <div class="test">
        <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
            <div class="navbar-header">
                <span class="navbar-brand">Accordous</span>
            </div>
            <div class="collapse navbar-collapse">
                <div class="navbar-nav">
                    <router-link to="/properties" class="nav-item nav-link">Properties</router-link>
                    <router-link to="/contracts" class="nav-item nav-link">Contracts</router-link>
                </div>
            </div>
        </nav>
        <br>
        <div class="container">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
    export default {}
</script>
