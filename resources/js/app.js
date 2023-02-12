import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/inertia-vue3'
// import 'bootstrap-vue/dist/bootstrap-vue.css';
// import 'bootstrap/dist/css/bootstrap.css';
// import "bootstrap/dist/css/bootstrap.min.css"
// import "bootstrap"
import 'feather-icons'

import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { Link } from '@inertiajs/inertia-vue3'
import Header from './Pages/Header.vue'
import { InertiaProgress } from '@inertiajs/progress'
import HighchartsVue from 'highcharts-vue'

import Highcharts from "highcharts";
import ExportingHighcharts from "highcharts/modules/exporting";

import DataTable from 'datatables.net-vue3'
// import Select from 'datatables.net-select';
import DataTableBs5 from 'datatables.net-bs5';
 
// DataTable.use(Select);
DataTable.use(DataTableBs5);

ExportingHighcharts(Highcharts);

createInertiaApp({
  resolve: name => require(`./Pages/${name}`),
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .component("font-awesome-icon", FontAwesomeIcon)
      .component("Link", Link)
      .component("HighchartsVue", HighchartsVue)
      .mount(el)

  },
  components: {
    Header
  }
});

InertiaProgress.init({
  color: 'red',
  showSpinner: true,
});
