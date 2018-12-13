import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        dataLiveBarging: [],
        jetties: [],
        buyers: [],
        tugboats: [],
        barges: [],
        customers: [],
        contractors: [],
        seams: [],
        bargingStatuses: ["Initiate", "Loading", "Breakdown", "Delay", "Idle", "Complete"],
        bargingColors: ["info", "success", "danger", "warning", "default", "primary"],
    },
    mutations: {
        getLiveBargingData: function(state) {
            axios.get(BASE_URL + '/jetty/productivity').then(function(r) {
                state.dataLiveBarging = r.data
            })
        },
        getJetty: function(state) {
            axios.get(BASE_URL, + 'api/jetty').then(function(r) {
                state.jetties = r.data
            })
        },
        getBuyers: function(state) {
            axios.get(BASE_URL, + 'api/buyer').then(function(r) {
                state.buyers = r.data
            })
        },
        getTugboats: function(state) {
            axios.get(BASE_URL, + 'api/tugboat').then(function(r) {
                state.tugboats = r.data
            })
        },
        getBarges: function(state) {
            axios.get(BASE_URL, + 'api/barge').then(function(r) {
                state.barges = r.data
            })
        },
        getCustomers: function(state) {
            axios.get(BASE_URL, + 'api/customer').then(function(r) {
                state.customers = r.data
            })
        },
        getContractors: function(state) {
            axios.get(BASE_URL, + 'api/contractor').then(function(r) {
                state.contractors = r.data
            })
        },
        getSeams: function(state) {
            axios.get(BASE_URL, + 'api/seam').then(function(r) {
                state.seams = r.data
            })
        },
    }
})
