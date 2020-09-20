<template>
  <v-container v-if="!me">
  <v-dialog v-model="dialog" max-width="500px">
    <template v-slot:activator="{ on, attrs }">
      <v-btn
        color="black"
        dark
        class="mb-2"
        v-bind="attrs"
        v-on="on"
      >LOGIN</v-btn>
    </template>
    <v-card>
      <v-card-title>
        <span class="headline">LOGIN</span>
      </v-card-title>
      <v-form v-model="valid" style="margin: 10px">
        <v-text-field
          v-model="email"
          :rules="emailRules"
          label="E-mail"
          required
        />
        <v-text-field
          v-model="password"
          :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
          :rules="[passwordRules.required, passwordRules.min]"
          :type="'password'"
          label="Password"
          counter
          @click:append="show1 = !show1"
        ></v-text-field>
      </v-form>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="blue darken-1" text @click="onSubmitForm">LOGIN</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
  </v-container>
  <v-container v-else>
    <v-card-actions>
      <v-spacer></v-spacer>
      <v-btn color="blue darken-1" text @click="onLogOut">LOGOUT</v-btn>
    </v-card-actions>
  </v-container>
</template>

<script>
export default {
  name: "Login",
  data: () => ({
    dialog: false,
    valid: false,
    show1:false,
    show2:false,
    email: '',
    emailRules: [
      v => !!v || 'E-mail is required',
      v => /.+@.+/.test(v) || 'E-mail must be valid',
    ],
    password:'',
    passwordRules: {
      required: value => !!value || 'Required.',
      min: v => v.length >= 8 || 'Min 8 characters',
    },
  }),
  computed: {
    me() {
      return this.$store.state.me;
    },
  },
  methods: {
    onSubmitForm() {
      this.$store.dispatch('logIn', {
        email: this.email,
        password: this.password,
      });
    },
    onLogOut() {
      this.$store.dispatch('logOut');
    },
  }
}
</script>

<style scoped>

</style>
