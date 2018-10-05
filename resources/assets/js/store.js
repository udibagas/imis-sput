import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        dataLiveBarging: []
    },
    mutations: {
        getLiveBargingData: function(state) {
            axios.get(BASE_URL + '/jetty/productivity').then(function(r) {
                state.dataLiveBarging = r.data
            })
        }
    }
})
