export const state = () => ({
  posts: [],
});

const url = 'http://localhost:8000/api'

export const mutations = {
  addMainPost(state, payload) {
    state.posts.unshift(payload);
  },
  // removeMainPost(state, payload) {
  //   const index = state.mainPosts.findIndex(v => v.id === payload.id);
  //   state.mainPosts.splice(index, 1);
  // },
  loadPosts(state, payload) {
    state.posts = payload.posts;
  },
};

export const actions = {
  add({ commit }, payload) {
    this.$axios.post(`${url}/post`,{
      title:payload.title,
      content:payload.content,
    }, {
      withCredentials: false,
      headers: {
        Authorization:`Bearer ${this.$store}`
      }
    })
      .then((res) => {
        commit('addMainPost', res.data);
      })
      .catch((err) => {
        console.error(err);
      });
    commit('addMainPost', payload);
  },
  remove({ commit }, payload) {
    commit('removeMainPost', payload);
  },
  loadPosts({ commit }) {
    this.$axios.get(`${url}/posts`, {
      withCredentials: false,
    })
      .then((res) => {
        commit('loadPosts', res.data);
      })
      .catch((err) => {
        console.error(err);
      });
  }
};
