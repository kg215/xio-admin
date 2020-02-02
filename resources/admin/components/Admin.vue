<template>
    <div class="admin">
        <router-view></router-view>
    </div>
</template>

<script>
    import router,{dynamicRoutes} from "../router";

    export default {
        name: "Admin",
        beforeCreate(){
            !localStorage.getItem("login")&&router.history.current.path!=="/login"&&router.push("/login");
            localStorage.getItem("login")&&router.addRoutes(dynamicRoutes);
        }
    }
</script>
