<template >
  <div>
    <b-alert
      v-if="errorLogin"
      variant="danger"
      dismissible
      show
    >Houve um erro, impossivel entrar com essas credenciais.</b-alert>

    <form class="col-5 center" autocomplete="off" @submit.prevent="login()" method="post">
      <div class="form-group">
        <label for="email">E-mail</label>
        <input
          type="email"
          id="email"
          class="form-control"
          placeholder="user@example.com"
          v-model="email"
          required
        />
      </div>
      <div class="form-group">
        <label for="password">Senha</label>
        <input type="password" id="password" class="form-control" v-model="password" required />
      </div>
      <button type="submit" class="btn btn-info">Entrar</button>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      email: "usuario@email.com",
      password: null,
      errorLogin: false
    };
  },
  methods: {
    login() {
      this.$http
        .post(
          "login",
          { email: this.email, password: this.password },
          {
            headers: {
              "Content-Type": "application/json"
              // Authorization: "Bearer " + this.getToken
            }
          }
        )
        .then(res => {
          this.loginSuccessful(res);
        })
        .catch(function(error) {
          /* eslint-disable */
          console.log(error);
        });
    },
    loginSuccessful(req) {
      if (!req.data.access_token) {
        this.loginFailed();
        return;
      }

      localStorage.token = req.data.access_token;
      this.errorLogin = false;

      this.$store.state.token = req.data.access_token;
      this.$router.push("/product");
    },

    loginFailed() {
      this.errorLogin = "Login failed!";
      delete localStorage.token;
    }
  }
};
</script>

<style>
</style>
