<template>
    <div>
        <Header />
        <b-container fluid>
             <!-- <transition enter-active-class="animated fadeIn"
                leave-active-class="animated fadeOut" mode="out-in"> -->
                <router-view></router-view>
            <!-- </transition> -->
        </b-container>
    </div>
</template>

<script>
import Header from "./components/Header";
  export default {
    components: { Header },
    
    // mounted: {
    //     console.log(tokek)
    // },
    methods: {
        logout(){
            // console.log("Saiu")
            this.$http.post('/logout')
            .then(res =>{
                alert(res.data.message)

            })
            .catch(function (error) {
                 /* eslint-disable */
                console.log(error)
            }); 
        },
    }
  }
</script>

<style>

</style>
