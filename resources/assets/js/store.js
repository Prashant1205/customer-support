import Vue from 'vue'
import Vuex from 'vuex'
Vue.use(Vuex);
import createPersistedState from 'vuex-persistedstate'
import * as Cookies from 'js-cookie'

const store = new Vuex.Store({
	state: {
		auth: {
			email: '',
			name:'',
		},
	},
	mutations: {
		setAuthUserDetail (state, auth) {
        	for (let key of Object.keys(auth)) {
                state.auth[key] = auth[key];
            }
		},
		resetAuthUserDetail (state) {
        	for (let key of Object.keys(state.auth)) {
                state.auth[key] = '';
            }
		},
	},
	actions: {
		setAuthUserDetail ({ commit }, auth) {
     		commit('setAuthUserDetail',auth);
     	},
     	resetAuthUserDetail ({commit}){
     		commit('resetAuthUserDetail');
     	},
		setConfig ({ commit }, data) {
     		commit('setConfig',data);
     	}
	},
	getters: {
		getAuthUser: (state) => (name) => {
		    return state.auth[name];
		},
		getAuthUserFullName: (state) => {
		    return state.auth[name];
		},
	},
	plugins: [
		createPersistedState({ storage: window.sessionStorage })
	]
});

export default store;