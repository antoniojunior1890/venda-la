<template>
  <div> 
    <b-alert
      v-for="(message, index) in messageInfo"
      :key="index"
      variant="primary"
      dismissible
      show
    >{{ message }}</b-alert>
    <b-card class="mt-3" header="Kit">
      <b-card-body>
        <b-form>
          <b-form-group id="input-group-2" label="Nome:" label-for="input-2">
            <b-form-input id="input-2" v-model="kit.name" required placeholder="Nome"></b-form-input>
          </b-form-group>

          <b-form-group id="input-group-2" label="Preço:" label-for="input-2">
            <b-form-input id="input-2" v-model.number="kit.price" required placeholder="Preço"></b-form-input>
          </b-form-group>

        </b-form>
          <b-card class="mt-3" header="Produtos Kit">
            <b-card-body>
                <vue-bootstrap-typeahead
                  class="mb-4"
                  v-model="query"
                  :data="productSearch"
                  :serializer="data => data.label"
                  @hit="selectedUser = $event"
                  placeholder="Produto para o kit"
                />
         <b-table striped hover :items="items" :fields="fields">
           <template slot="qtd" slot-scope="row">
                <b-form-input v-model="row.qtd" @change="editQtdProduct(row)" class="col-1" ></b-form-input>
              </template>
         </b-table>
          <b-button @click="sendKit" variant="primary">Salvar</b-button>
      </b-card-body>
    </b-card>
      </b-card-body>
    </b-card>
  </div>
</template>

<script>
import VueBootstrapTypeahead from "vue-bootstrap-typeahead";
export default {
  components: {
    VueBootstrapTypeahead
  },
  data() {
    return {
      // text: '',
      query: "",
      selectedUser: null,
      productSearch: [],
      kit: {
        name: "",
        price: 0
      },
      selectMode: "multi",
      selected: [],
      fields: [
        { id: "#" },
        { value: "Nome" },
        { price: "Preco" },
        { qtd: "Quantidade" },
      ],
      items: [],
      messageInfo: [],
    };
  },
  methods: {
    sendKit(){
      this.kit.products = this.items
      this.$http
        .post('kits', this.kit ,{
          headers: {
            "Content-Type": "application/json",
            Authorization: "Bearer " + this.$store.getters.getToken
          }
        })
        .then(res => {
           /* eslint-disable */
          // console.log(res);
          if(res.data){
            res.data.map(item => {
              this.messageInfo.push(item.data.msg);
            });
          }
          this.kit = {};
          this.items= []
        });
    },
    editQtdProduct(row){
      const element = this.items.find(item => item.id === row.item.id)
      const indice = this.items.indexOf(element)
      element.qtd = row.qtd
      this.items.splice(indice, 1, element);
    },
  },
  watch: {
    query(newQuery) {
      this.$http
        .get(`autocomplete?query=${newQuery}`, {
          headers: {
            "Content-Type": "application/json",
            Authorization: "Bearer " + this.$store.getters.getToken
          }
        })
        .then(res => {
          this.productSearch = res.data;
        });
    },
    selectedUser(param){
      this.items.push(param)
    },
  },
};
</script>

<style>
</style>
