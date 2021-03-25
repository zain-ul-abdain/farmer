/* Dashboard*/

var aj;
if (window.XMLHttpRequest) {
  aj = new XMLHttpRequest();
} else {
  aj = new ActiveXObject("Microsoft.XMLHTTP");
}

function _dashboard() {
  aj.onreadystatechange = function () {
    if (aj.readyState == 4 && aj.status == 200) {
      document.getElementById("content").innerHTML = aj.responseText;
      document.getElementById("dashboard").className = "nav-link active";
      document.getElementById("consultant").className = "nav-link";
      document.getElementById("knowledge_base").className = "nav-link";
    }
  };

  aj.open("POST", "pages/dashboard.php");
  aj.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  aj.send("action=dashboard");
}

/* Consultancy Service*/
function _consultant() {
  aj.onreadystatechange = function () {
    if (aj.readyState == 4 && aj.status == 200) {
      document.getElementById("content").innerHTML = aj.responseText;
      document.getElementById("knowledge_base").className = "nav-link";
      document.getElementById("dashboard").className = "nav-link";
      document.getElementById("consultant").className = "nav-link active";
    }
  };

  aj.open("POST", "pages/consultants.php");
  aj.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  aj.send("action=consultant");
}

/* Knowledge Base*/
function _knowledge_base(p = 1) {
  var pageno = p;

  aj.onreadystatechange = function () {
    if (aj.readyState == 4 && aj.status == 200) {
      document.getElementById("content").innerHTML = aj.responseText;
      document.getElementById("dashboard").className = "nav-link";
      document.getElementById("consultant").className = "nav-link";
      document.getElementById("knowledge_base").className = "nav-link active";
    }
  };

  aj.open("POST", "pages/knowledge_base.php");
  aj.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  aj.send("action=knowledge_base&page_no=" + pageno);
}

/* Discussion Forum*/
function _discussion_forum(p = 1) {
  var pageno = p;

  aj.onreadystatechange = function () {
    if (aj.readyState == 4 && aj.status == 200) {
      document.getElementById("content").innerHTML = aj.responseText;
      document.getElementById("knowledge_base").className = "nav-link";
      document.getElementById("dashboard").className = "nav-link";
      document.getElementById("consultant").className = "nav-link";
      document.getElementById("discussion_forum").className = "nav-link active";
    }
  };

  aj.open("POST", "pages/discussion_forum.php");
  aj.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  aj.send("action=discussion_forum&page_no=" + pageno);
}

/* E-Commerce*/
function _e_commerce() {
  aj.onreadystatechange = function () {
    if (aj.readyState == 4 && aj.status == 200) {
      document.getElementById("content").innerHTML = aj.responseText;
    }
  };

  aj.open("POST", "pages/shop/shop.php");
  aj.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  aj.send();
}

/* Manage Users*/
function _manage() {
  aj.onreadystatechange = function () {
    if (aj.readyState == 4 && aj.status == 200) {
      document.getElementById("content").innerHTML = aj.responseText;
      document.getElementById("consultant").className = "nav-link";
      document.getElementById("dashboard").className = "nav-link";
      document.getElementById("knowledge_base").className = "nav-link";
      document.getElementById("discussion_forum").className = "nav-link";
      document.getElementById("manage").className = "nav-link nav-link active";

      document.getElementById(
        "user_active"
      ).innerHTML = document.getElementById("c");
    }
  };

  aj.open("POST", "pages/manage_users.php");
  aj.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  aj.send("action=manage_users");
}

/* Add Post*/
function add_post() {
  aj.onreadystatechange = function () {
    if (aj.readyState == 4 && aj.status == 200) {
      document.getElementById("content").innerHTML = aj.responseText;
    }
  };

  aj.open("POST", "pages/post_process.php");
  aj.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  aj.send("action=post_process");
}

/* Approve new User*/
function is_approved(s, id) {
  var status = s.name;

  aj.onreadystatechange = function () {
    if (aj.readyState == 4 && aj.status == 200) {
      _manage();
    }
  };

  aj.open("POST", "pages/manage_users.php");
  aj.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  aj.send("action=update_user&id=" + id + "&status=" + status);
}

/* Active/Inactive User*/
function active(s, id) {
  var status = s.name;

  aj.onreadystatechange = function () {
    if (aj.readyState == 4 && aj.status == 200) {
      _manage();
    }
  };

  aj.open("POST", "pages/manage_users.php");
  aj.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  aj.send("action=active_user&id=" + id + "&status=" + status);
}

/* Rating Consultant*/
function _detail(a, b) {
  var id = a;
  var num = b;

  aj.onreadystatechange = function () {
    if (aj.readyState == 4 && aj.status == 200) {
      document.getElementById("content").innerHTML = aj.responseText;
    }
  };

  aj.open("POST", "pages/detail.php");
  aj.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  aj.send("action=detail&post_id=" + id + "&num=" + num);
}

/* Add Product Form*/
function add_product_form() {
  aj.onreadystatechange = function () {
    if (aj.readyState == 4 && aj.status == 200) {
      document.getElementById("product_form").innerHTML = aj.responseText;
    }
  };

  aj.open("POST", "forms/add_product_form.php");
  aj.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  aj.send();
}

/* Add Product Form*/
function change_product_image(obj) {
  document.getElementById("main").src = obj;
}

/* Show single category posts*/
function category_post(a, n) {
  var id = a;

  aj.onreadystatechange = function () {
    if (aj.readyState == 4 && aj.status == 200) {
      document.getElementById("filter").innerHTML = aj.responseText;
    }
  };

  aj.open("POST", "pages/category_post.php");
  aj.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  if (n == 2) {
    aj.send("action=df&id=" + id);
  } else {
    aj.send("action=kb&id=" + id);
  }
}

/* Show single category posts*/
function product_details(a) {
  var id = a;

  aj.onreadystatechange = function () {
    if (aj.readyState == 4 && aj.status == 200) {
      document.getElementById("content").innerHTML = aj.responseText;
    }
  };

  aj.open("POST", "pages/e_commerce.php");
  aj.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  aj.send("id=" + id);
}

/* Light Box*/
function light_box(obj) {
  document.getElementById("img_box").src = obj.getAttribute("src");
  document.getElementById("display_box").style.display = "block";
  document.getElementById("blur").style.display = "none";
}

/* Close light box*/
function _close() {
  document.getElementById("display_box").style.display = "none";
  document.getElementById("blur").style.display = "block";
}

/* Add comment Knowledge Base*/
function _comment(p, u, a) {
  var comment = document.getElementById("comment").value;

  aj.onreadystatechange = function () {
    if (aj.readyState == 4 && aj.status == 200) {
      _detail(p, a);
    }
  };

  aj.open("POST", "pages/comment.php");
  aj.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  aj.send(
    "action=comment&comment=" + comment + "&post_id=" + p + "&user_id=" + u
  );
}

/* Add Like Knowledge Base*/
function _like(p, u, a) {
  aj.onreadystatechange = function () {
    if (aj.readyState == 4 && aj.status == 200) {
      _detail(p, a);
    }
  };

  aj.open("POST", "pages/comment.php");
  aj.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  aj.send("action=like&post_id=" + p + "&user_id=" + u + "&a=" + a);
}

/* Add Like Knowledge Base*/
function _star(stars) {
  document.getElementById("star").value = stars;
}

/* Rating Consultant*/
function _rating(star, msg) {
  // var star = document.getElementId("star").value;
  // var msg = document.getElementId("rating_msg").value;

  alert(star, msg);
}

/* Chat with Consultant*/
function chat_open(a, b) {
  var id = a;
  var category_id = b;

  aj.onreadystatechange = function () {
    if (aj.readyState == 4 && aj.status == 200) {
      document.getElementById("content").innerHTML = aj.responseText;
    }
  };

  aj.open("POST", "pages/consultant_chat.php");
  aj.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  aj.send("action=consultant_chat&id=" + id + "&category_id=" + category_id);
}

function chat_start(u,c) {

  let txt = document.getElementById("txt").value;
  alert("User: "+u);
  alert("Consultant: "+c);
  alert("Query: "+txt);

  aj.onreadystatechange = function () {
    if (aj.readyState == 4 && aj.status == 200) {
      // document.getElementById("content").innerHTML = aj.responseText;
      alert(aj.responseText);
    }
  };

  aj.open("POST", "pages/consultant_process.php");
  aj.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  aj.send("action=consultant_chat&user_id=" + u + "&consultant_id=" + consultant_id+ "&query=" + txt);
}
