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
        style="margin-right: 10px"
      >SIGN UP</v-btn>
    </template>
    <v-card>
      <v-card-title>
        <span class="headline">SIGN UP</span>
      </v-card-title>
      <v-form v-model="valid" style="margin: 10px">
        <v-text-field
          v-model="email"
          :rules="emailRules"
          label="E-mail"
          required
        />
        <v-text-field
          v-model="name"
          :rules="nameRules"
          :counter="10"
          label="Name"
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
        <v-text-field
          v-model="password_confirmation"
          :append-icon="show2 ? 'mdi-eye' : 'mdi-eye-off'"
          :rules="passwordCheckRules"
          :type="'password'"
          label="PasswordCheck"
          counter
          @click:append="show2 = !show2"
        ></v-text-field>
      </v-form>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="blue darken-1" text @click="onSubmitForm">SIGNUP</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
  </v-container>
  <v-container v-else>
    <h2 style="color: gray">{{me.name}}, Hello!</h2>
  </v-container>
</template>

<script>
export default {
  name: "SignUp",
  data: () => ({
    dialog: false,
    valid: false,
    show1:false,
    show2:false,
    name: '',
    nameRules: [
      v => !!v || 'Name is required',
      v => v.length <= 10 || 'Name must be less than 10 characters',
    ],
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
    password_confirmation:'',
    passwordCheckRules: [
      value => !!value || 'Required.',
      v => v.length >= 8 || 'Min 8 characters',
    ],
  }),
  computed: {
    me() {
      return this.$store.state.me;
    },
  },
  methods: {
    onSubmitForm() {
      this.$store.dispatch('signUp', {
        email: this.email,
        name: this.name,
        password: this.password,
        password_confirmation: this.password_confirmation,
      });
    },
  },
}
</script>

<style scoped>

</style>
