class Evenement {
  constructor() {
    this.event_liste = global_event_array;

    this.is_in = function (l, d) {
      let result = false;
      l.forEach((e) => {
        if (e[0] == d[0] && e[1] == d[1] && e[2] == d[2]) {
          result = true;
        }
      });
      return result;
    };

    this.delete_event = function (id) {
      $.ajax({
        method: "get",
        url: "../php_traite_pages/delete_event_traite.php",
        data: {
          event_id: id,
          ajax: true,
        },
        success: function (data) {
          location.reload();
        },
      });
    };

    this.draw_event = function () {
      var month = [
        "Janvier",
        "Février",
        "Mars",
        "Avril",
        "Mai",
        "Juin",
        "Juillet",
        "Août",
        "Septembre",
        "Octobre",
        "Novembre",
        "Décembre",
      ];
      var event_section_list = [];
      var actual_date = new Date();
      this.event_liste
        .filter((e) => actual_date - new Date(e[5]) < 0)
        .forEach((e) => {
          let event_title_bd = e[1];
          let event_desc_bd = e[2];
          let event_place_bd = e[3];
          let event_start_date_bd = new Date(e[4]);
          let event_end_date_bd = new Date(e[5]);
          let event_start_date_string =
            ("0" + event_start_date_bd.getHours()).slice(-2) +
            ":" +
            ("0" + event_start_date_bd.getMinutes()).slice(-2) +
            " - ";
          let event_end_date_string =
            ("0" + event_end_date_bd.getHours()).slice(-2) +
            ":" +
            ("0" + event_end_date_bd.getMinutes()).slice(-2);

          let main_div = document.getElementById("main");

          // Création de la section événement titre
          let event_section_list_test = [
            event_start_date_bd.getDate(),
            event_start_date_bd.getMonth(),
            event_start_date_bd.getFullYear(),
          ];
          if (!this.is_in(event_section_list, event_section_list_test)) {
            event_section_list.push(event_section_list_test);
            const event_section = document.createElement("div");
            event_section.className = "event_section";
            event_section.innerHTML =
              "Événement du " +
              event_section_list_test[0] +
              " " +
              month[event_section_list_test[1]] +
              " " +
              event_section_list_test[2];

            main_div.appendChild(event_section);
          }
          //Création du block événement
          const event_div = document.createElement("div");
          event_div.className = "event_div";
          main_div.appendChild(event_div);

          // Ajout du bouton delete au block événement
          const event_delete_button = document.createElement("img");
          event_delete_button.className = "event_delete_button";
          event_delete_button.id = e[0];
          event_delete_button.src = "../../src/remove.png";
          event_delete_button.onclick = function () {
            new Evenement().delete_event(e[0]);
          };

          event_div.appendChild(event_delete_button);

          // Ajout du titre au block événement
          const event_title = document.createElement("p");
          event_title.className = "event_title";
          event_title.innerHTML = event_title_bd;
          event_div.appendChild(event_title);

          // Ajout de la description au block événement
          const event_desc = document.createElement("p");
          event_desc.className = "event_desc";
          event_desc.innerHTML = event_desc_bd;
          event_div.appendChild(event_desc);

          // Ajout du block date et lieu au block événement
          const event_time_place = document.createElement("div");
          event_time_place.className = "event_time_place";
          event_div.appendChild(event_time_place);

          // Ajout de la date au block date et lieu
          const event_time = document.createElement("p");
          event_time.className = "event_time";
          event_time.innerHTML =
            event_start_date_string + event_end_date_string;
          event_time_place.appendChild(event_time);

          // Ajout du lieu au block date et lieu
          const event_place = document.createElement("p");
          event_place.className = "event_place";
          event_place.innerHTML = event_place_bd;
          event_time_place.appendChild(event_place);
        });
    };
  }
}

window.onload = function () {
  var evenement = new Evenement();
  evenement.draw_event();
};
