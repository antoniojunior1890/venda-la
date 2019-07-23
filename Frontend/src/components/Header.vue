<template>
  <div>
    <b-navbar toggleable="lg" type="dark" variant="info">
      <b-navbar-brand to="home" exact>Home</b-navbar-brand>

      <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

      <b-collapse id="nav-collapse" is-nav>
        <b-navbar-nav>
          <b-nav-item v-if="this.$store.state.token" to="kit" exact>Kits</b-nav-item>
          <b-nav-item v-if="this.$store.state.token" to="product" exact>Produtos</b-nav-item>
        </b-navbar-nav>

        <!-- Right aligned nav items -->
        <b-navbar-nav class="ml-auto">
          <b-nav-item-dropdown right>
            <!-- Using 'button-content' slot -->
            <template slot="button-content">
              <em>Usuario</em>
            </template>
            <b-dropdown-item to="login">Logar</b-dropdown-item>
            <b-dropdown-item href="#" @click.prevent="logout()">Sair</b-dropdown-item>
          </b-nav-item-dropdown>
        </b-navbar-nav>
      </b-collapse>
    </b-navbar>
  </div>
</template>

<script>
export default {
  methods: {
    logout() {
      this.$http
        .post(
          "logout",
          { email: this.email, password: this.password },
          {
            headers: {
              "Content-Type": "application/json",
              Authorization: "Bearer " + this.$store.state.token
            }
          }
        )
        .then(res => {
          // eslint-disable-next-line
          console.log(res.data.message);
          alert("Sucesso ao sair.")
          this.$store.state.token = "";
          this.$router.push("/");
        })
        .catch(function(error) {
          this.$store.state.token = "";
          // eslint-disable-next-line
          console.log(error);
        })
        .finally(function (){
          delete localStorage.token;
        });
    }
  }
};
</script>

<style>
</style>
