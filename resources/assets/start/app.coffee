Vue.use require 'vue-resource'
Vue.http.headers.common['X-CSRF-TOKEN'] = $('meta[name="csrf-token"]').attr('content')

app = new Vue
	el: '#app'
