function autocomplete(inp, arr) {
  var cfocus;
  var a;

  console.log(arr);

  inp.addEventListener("input", function (e) {
    var val = this.value;
    closeAll();
    if (!val) {
      return false;
    }
    cfocus = -1;
    a = createAutocompleteList();

    for (var i = 0; i < arr.length; i++) {
      if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
        var b = createAutocompleteItem(arr[i]);
        b.addEventListener("click", function (e) {
          inp.value = this.getElementsByTagName("input")[0].value;
          closeAll();
        });
        a.appendChild(b);
      }
    }
  });

  inp.addEventListener("keydown", function (p) {
    var q = document.getElementById(this.id + "ac-list");
    if (q) {
      q = q.getElementsByTagName("div");
    }
    if (p.keyCode == 13) {
      p.preventDefault();
      if (cfocus > -1 && q) {
        q[cfocus].click();
      }
    } else if (p.keyCode == 40) {
      cfocus++;
      addActiveClass(q);
    } else if (p.keyCode == 38) {
      cfocus--;
      addActiveClass(q);
    }
  });

  function createAutocompleteList() {
    var list = document.createElement("div");
    list.setAttribute("id", inp.id + "ac-list");
    list.setAttribute("class", "ac-items");
    inp.parentNode.appendChild(list);
    return list;
  }

  function createAutocompleteItem(value) {
    var item = document.createElement("div");
    item.innerHTML = "<strong>" + value.substr(0, inp.value.length) + "</strong>";
    item.innerHTML += value.substr(inp.value.length);
    item.innerHTML += "<input type='hidden' value='" + value + "'>";
    return item;
  }
  function addActiveClass(q) {
    if (!q) {
      return false;
    }
    removeActiveClass(q);
    if (cfocus >= q.length) {
      cfocus = 0;
    }
    if (cfocus < 0) {
      cfocus = q.length - 1;
    }
    q[cfocus].classList.add("ac-active");
  }

  function removeActiveClass(q) {
    for (var i = 0; i < q.length; i++) {
      q[i].classList.remove("ac-active");
    }
  }

  function closeAll(elm) {
    var x = document.getElementsByClassName("ac-items");
    for (var i = 0; i < x.length; i++) {
      if (elm != x[i] && elm != inp) {
        x[i].parentNode.removeChild(x[i]);
      }
    }
  }
}
