import "vuetify/styles";
import { createVuetify } from "vuetify";
import "@mdi/font/css/materialdesignicons.css"; // <- Import MDI

export default createVuetify({
  icons: {
    defaultSet: "mdi",
  },
});
