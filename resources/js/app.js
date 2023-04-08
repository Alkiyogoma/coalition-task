import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'

import { Link } from '@inertiajs/vue3'
import Header from './Pages/Header.vue'
import HighchartsVue from 'highcharts-vue'

import Highcharts from "highcharts";
import ExportingHighcharts from "highcharts/modules/exporting";

import DataTable from 'datatables.net-vue3'
import DataTableBs5 from 'datatables.net-bs5';
 
DataTable.use(DataTableBs5);

ExportingHighcharts(Highcharts);

createInertiaApp({
  resolve: name => require(`./Pages/${name}`),
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .component("Link", Link)
      .component("HighchartsVue", HighchartsVue)
      .mount(el)

  },
  progress: {
    color: '#29d',
    showSpinner: true,
},
  components: {
    Header
  }
});
