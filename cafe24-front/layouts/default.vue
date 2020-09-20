<template>
  <v-app dark>
    <v-card class="overflow-hidden">
      <v-app-bar
        absolute
        color="#fcb69f"
        dark
        shrink-on-scroll
        src="/back2.jpg"
        scroll-target="#scrolling-techniques-2"
      >
        <v-tabs>
          <v-tab v-text="title" style="width: 120px; color: black" disabled/>
          <v-tab nuxt to="/">
              Home
          </v-tab>
          <v-tab nuxt to="/gallery">
              Gallery
          </v-tab>
          <v-tab nuxt to="/post">
              Post
          </v-tab>
          <v-spacer/>
          <v-tab>
            <SignUp/>
          </v-tab>
          <v-tab>
            <Login/>
          </v-tab>
        </v-tabs>
      </v-app-bar>
      <v-sheet
        id="scrolling-techniques-2"
        class="overflow-y-auto"
        max-height="100vh"
      >
        <v-main>
          <v-container style="padding-top: 200px; height: 100vh">
            <nuxt/>
          </v-container>
        </v-main>
      </v-sheet>
    </v-card>
  </v-app>
</template>

<script>

import SignUp from "@/components/SignUp";
import Login from "@/components/Login";
export default {
  components: {Login, SignUp},
  data: () => ({
    title: 'CAFE 24',
    valid: false,
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
    passwordCheck:'',
    passwordRules: [
      v => !!v || 'Password is required',
      v => v.length > 6 || 'Password must be more than 6 characters',
    ],
  }),
  methods: {

  },
}
</script>
