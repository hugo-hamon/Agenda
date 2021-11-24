// Classe permettant de gerer l'agenda
class Agenda {
  constructor(m, y) {
    this.m = m;
    this.y = y;
    this.base_year = y;

    this.show_evenement = function (td_id) {
      // Affichage ou désaffichage des ajouts d'événement / événement utilisateur
      let event_div_is_hidden = document.getElementById("evenement_div");
      let user_event_div_is_hidden = document.getElementById("user_event_div");
      event_div_is_hidden.hidden = !event_div_is_hidden.hidden;
      user_event_div_is_hidden.hidden = !user_event_div_is_hidden.hidden;

      if (!user_event_div_is_hidden.hidden) {
        this.draw_user_event(td_id);
      }
    };

    this.draw_user_event = function (td_id) {
      var user_event_div = document.getElementById("user_event_div");
      document.getElementById("user_event_div").innerHTML = "";
      // Ajout du titre au block évnement
      const user_event_caption = document.createElement("p");
      user_event_caption.id = "user_event_caption";
      user_event_caption.innerHTML = "Vos événements";
      user_event_div.appendChild(user_event_caption);

      global_event_array
        .filter(
          (e) =>
            td_id == new Date(e[4]).getDate() &&
            this.m == new Date(e[4]).getMonth() &&
            this.y == new Date(e[4]).getFullYear()
        )
        .forEach((e) => {
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

          //Création du block user événement
          const user_event_child_div = document.createElement("div");
          user_event_child_div.className = "user_event_child_div";
          user_event_div.appendChild(user_event_child_div);

          // Ajout du titre au block événement
          const user_event_title = document.createElement("p");
          user_event_title.className = "user_event_title";
          user_event_title.innerHTML = e[1];
          user_event_child_div.appendChild(user_event_title);

          // Ajout de la description au block événement
          const user_event_desc = document.createElement("p");
          user_event_desc.className = "user_event_desc";
          user_event_desc.innerHTML = e[2];
          user_event_child_div.appendChild(user_event_desc);

          // Ajout du block date et lieu au block événement
          const user_event_time_place = document.createElement("div");
          user_event_time_place.className = "user_event_time_place";
          user_event_child_div.appendChild(user_event_time_place);

          // Ajout de la date au block date et lieu
          const user_event_time = document.createElement("p");
          user_event_time.className = "user_event_time";
          user_event_time.innerHTML =
            event_start_date_string + event_end_date_string;
          user_event_time_place.appendChild(user_event_time);

          // Ajout du lieu au block date et lieu
          const user_event_place = document.createElement("p");
          user_event_place.className = "user_event_place";
          user_event_place.innerHTML = e[3];
          user_event_time_place.appendChild(user_event_place);
        });
    };

    this.is_event_day = function (day, event_list) {
      let k = event_list.length;
      for (let i = 0; i < k; ++i) {
        let event_date = [
          event_list[i].getDate(),
          event_list[i].getMonth(),
          event_list[i].getFullYear(),
        ];
        if (
          event_date[0] == day &&
          event_date[1] == this.m &&
          event_date[2] == this.y
        ) {
          return 0;
        }
      }
      return -1;
    };

    this.is_holyday = function (day) {
      var n = this.y % 19;
      var c = Math.floor(this.y / 100);
      var u = this.y % 100;
      var s = Math.floor(c / 4);
      var t = c % 4;
      var p = Math.floor((c + 8) / 25);
      var q = Math.floor((c - p + 1) / 3);
      var e = (19 * n + c - s - q + 15) % 30;
      var b = Math.floor(u / 4);
      var d = u % 4;
      var L = (2 * t + 2 * b - e - d + 32) % 7;
      var h = Math.floor((n + 11 * e + 22 * L) / 451);
      var m = Math.floor((e + L - 7 * h + 114) / 31);
      var j = (e + L - 7 * h + 114) % 31;

      var mois_paque = m - 1;
      var jour_paques = j + 1;

      var holydays = [
        new Date(this.y, "00", "01"), // Jour de l'an
        new Date(this.y, "04", "01"), // Fete du travail
        new Date(this.y, "04", "08"), // 1945
        new Date(this.y, "06", "14"), // Fete Nationale
        new Date(this.y, "07", "15"), // Assomtion
        new Date(this.y, "10", "01"), // Toussaint
        new Date(this.y, "10", "11"), // Armistice
        new Date(this.y, "11", "25"), // Noel
        new Date(this.y, mois_paque, jour_paques), // Paques
        new Date(this.y, mois_paque, jour_paques + 1), // Lundi de Paques
        new Date(this.y, mois_paque, jour_paques + 39), // Ascension
        new Date(this.y, mois_paque, jour_paques + 49), // Pentecote
        new Date(this.y, mois_paque, jour_paques + 50), // Lundi Pentecote
      ];
      var is_in = false;

      holydays.forEach((d) => {
        if (d.getTime() == new Date(this.y, this.m, day).getTime()) {
          is_in = true;
        }
      });
      return is_in;
    };

    this.create_agenda = function () {
      // variables
      var nb_of_day = new Date(this.y, this.m + 1, 0).getDate();
      var first_day_of_month = new Date(this.y, this.m, 1).getDay();
      let month = [
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
      var event_list = [];
      // Obtention des jours événements
      global_event_array.forEach((e) => {
        let event_date = new Date(e[4]);
        event_list.push(event_date);
      });

      // Creation de la table
      const agenda_month_list = document.getElementById("month_list");

      const agenda_year_list = document.getElementById("year_list");

      for (let i = 0; i < month.length; i++) {
        const options = document.createElement("option");
        options.textContent = month[i];
        agenda_month_list.appendChild(options);
      }

      const options_title_month = document.createElement("option");
      options_title_month.id = "default_month";
      options_title_month.value = "";
      options_title_month.setAttribute("selected", true);
      options_title_month.setAttribute("disabled", true);
      options_title_month.setAttribute("hidden", true);
      options_title_month.innerHTML = month[this.m];
      agenda_month_list.appendChild(options_title_month);

      // Création de la liste déroulante pour les années
      for (let i = this.base_year - 100; i < this.base_year + 100; i++) {
        const options = document.createElement("option");
        options.textContent = i;
        agenda_year_list.appendChild(options);
      }

      const options_title_year = document.createElement("option");
      options_title_year.id = "default_year";
      options_title_year.value = "";
      options_title_year.innerHTML = this.y;
      options_title_year.setAttribute("selected", true);
      options_title_year.setAttribute("disabled", true);
      options_title_year.setAttribute("hidden", true);
      agenda_year_list.appendChild(options_title_year);

      //Création du corps de la table
      const agenda_tbody = document.getElementById("agenda_tbody");
      var current_day_nbr = 1;
      var self = this;

      for (
        var l = 0;
        l < Math.ceil((nb_of_day + first_day_of_month - 1) / 7);
        l++
      ) {
        let new_row = document.createElement("tr");
        agenda_tbody.appendChild(new_row);
        for (var c = 0; c < 7; c++) {
          var actual_day = new Date();
          let current_day = l * 7 + c + 1;
          let new_square = document.createElement("td");
          if (
            current_day >= first_day_of_month &&
            current_day < nb_of_day + first_day_of_month
          ) {
            new_square.innerHTML = current_day_nbr;
            new_square.id = current_day_nbr;
            new_square.className = "agenda_cells";

            if (
              actual_day.getDate() == current_day &&
              actual_day.getMonth() == this.m &&
              actual_day.getFullYear() == this.y
            ) {
              new_square.style.textDecoration = "underline";
            }

            actual_day.setFullYear(this.y);
            actual_day.setMonth(this.m);
            actual_day.setDate(current_day - first_day_of_month + 1);
            if (actual_day.getDay() == 6) {
              new_square.style.backgroundColor = "#C8E3D4";
              new_square.style.borderRadius = "20px";
              new_square.style.color = "white";
            }

            if (actual_day.getDay() == 0) {
              new_square.style.backgroundColor = "#87AAAA";
              new_square.style.borderRadius = "20px";
              new_square.style.color = "white";
            }

            if (this.is_event_day(current_day, event_list) == 0) {
              new_square.style.color = "red";
            }

            if (this.is_holyday(current_day - first_day_of_month + 1)) {
              new_square.style.color = "#00b9af";
            }

            new_square.onclick = function () {
              self.show_evenement(parseInt(this.id));
            };
            current_day_nbr++;
          }
          new_row.appendChild(new_square);
        }
      }
    };
    this.update = function () {
      const tbody = document.getElementById("agenda_tbody");
      tbody.innerHTML = "";
      $("#month_list option").remove();
      $("#year_list option").remove();
      this.create_agenda();
    };

    this.back_month = function () {
      this.m -= 1;
      if (this.m < 0) {
        this.y -= 1;
        this.m = 11;
      }
      this.update();
    };

    this.next_month = function () {
      this.m += 1;
      if (this.m > 11) {
        this.y += 1;
        this.m = 0;
      }
      this.update();
    };

    this.change_month = function (e) {
      let month = [
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
      this.m = month.indexOf(e);
      this.update();
    };

    this.change_year = function (e) {
      this.y = parseInt(e);
      this.update();
    };
  }
}

class Winter_Summer_Time {
  constructor() {
    this.get_time = function () {
      const d = new Date();
      let h = d.getHours();
      let m = d.getMinutes();
      let s = d.getSeconds();
      let winter_summer =
        d.getTimezoneOffset() == -120 ? " (heure d'été)" : " (heure d'hiver)";

      h = h < 10 ? "0" + h : h;
      m = m < 10 ? "0" + m : m;
      s = s < 10 ? "0" + s : s;

      return h + ":" + m + ":" + s + winter_summer;
    };

    this.set_time = function () {
      const show_time_element = document.getElementById("summer_winter_time");
      let time = this.get_time();
      show_time_element.innerHTML = time;
    };

    this.update_time = function () {
      var self = this;
      self.set_time();
      this.timer = setInterval(function () {
        self.set_time();
      }, 1000);
    };
  }
}

window.onload = function () {
  var agenda = new Agenda(new Date().getMonth(), new Date().getFullYear());
  agenda.create_agenda();

  var time = new Winter_Summer_Time();
  time.update_time();

  document.getElementById("back_month_button").onclick = function fun() {
    agenda.back_month();
  };

  document.getElementById("next_month_button").onclick = function fun() {
    agenda.next_month();
  };

  document.getElementById("month_list").onchange = function () {
    var index = this.selectedIndex;
    var inputText = this.children[index].innerHTML.trim();
    agenda.change_month(inputText);
  };
  document.getElementById("year_list").onchange = function () {
    var index = this.selectedIndex;
    var inputText = this.children[index].innerHTML.trim();
    agenda.change_year(inputText);
  };
};
