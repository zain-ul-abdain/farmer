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

  aj.open("POST", "pages/shop.php");
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

/* Manage Products*/
function _products() {

  aj.onreadystatechange = function () {
    if (aj.readyState == 4 && aj.status == 200) {
      document.getElementById("content").innerHTML = aj.responseText;
    }
  };

  aj.open("POST", "pages/manage_products.php");
  aj.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  aj.send("action=manage_products");
}

/* Manage _comments*/
function _comments() {

  aj.onreadystatechange = function () {
    if (aj.readyState == 4 && aj.status == 200) {
      document.getElementById("content").innerHTML = aj.responseText;
    }
  };

  aj.open("POST", "pages/manage_comments.php");
  aj.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  aj.send("action=manage_comments");
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

/* Active/Inactive User*/
function active_p(s, id) {
  var status = s.name;
  aj.onreadystatechange = function () {
    if (aj.readyState == 4 && aj.status == 200) {
      // _products();
      alert(aj.responseText);
    }
  };

  aj.open("POST", "pages/manage_products.php");
  aj.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  aj.send("action=active_product&id=" + id + "&status=" + status);
}

/* Featured Product*/
function is_approved_p(s, id) {
  var status = s.name;
  aj.onreadystatechange = function () {
    if (aj.readyState == 4 && aj.status == 200) {
      alert(aj.responseText);
    }
  };

  aj.open("POST", "pages/manage_products.php");
  aj.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  aj.send("action=featured&id=" + id + "&status=" + status);
}

/* Post active/inactive*/
function active_post(s, id) {
  var status = s.name;
  aj.onreadystatechange = function () {
    if (aj.readyState == 4 && aj.status == 200) {
      alert(aj.responseText);
      _comments();
    }
  };

  aj.open("POST", "pages/manage_comments.php");
  aj.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  aj.send("action=active_post&id=" + id + "&status=" + status);
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
function product_details(a,c_id) {
  var id = a;

  aj.onreadystatechange = function () {
    if (aj.readyState == 4 && aj.status == 200) {
      document.getElementById("content").innerHTML = aj.responseText;
    }
  };

  aj.open("POST", "pages/e_commerce.php");
  aj.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  aj.send("id=" + id + "&c_id="+c_id);
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

/* Add stars hidden field*/
function _star(stars) {
  var hidden = document.getElementById("stars").value = stars;
  // alert(hidden);
}

/* Rating Consultant*/
function _rating() {
  var star = document.getElementById("stars").value;
  var msg = document.getElementById("rating_msg").value;

  aj.onreadystatechange = function () {
    if (aj.readyState == 4 && aj.status == 200) {
      alert("Rated Successfully");
      _consultant();
      window.location = "index.php";
    }
  };

  aj.open("POST", "pages/consultant_process.php");
  aj.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  aj.send("action=consultant_rate&star=" + star + "&feedback=" + msg);
}

/* Chat with Consultant*/
function chat_open(a, b) {
  if (a != null) {
    var flag = false;
    var id = a;
    var category_id = b;

    var query = prompt("Ask Query");

    if (!query) {
      flag = true;
    }
  }
  aj.onreadystatechange = function () {
    if (aj.readyState == 4 && aj.status == 200) {
      if (flag) {
        _consultant();
      } else {
        document.getElementById("content").innerHTML = aj.responseText;
      }
    }
  };

  aj.open("POST", "pages/consultant_chat.php");
  aj.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  if (a != null) {
    aj.send("action=consultant_chat&id=" + id + "&category_id=" + category_id + "&query=" +query);
  } else {
    aj.send("action=consultant_chat_update");
  }
}

/* Chat Open*/
function chat_start() {
  let txt = document.getElementById("txt").value;

  aj.onreadystatechange = function () {
    if (aj.readyState == 4 && aj.status == 200) {
      chat_open();
    }
  };

  aj.open("POST", "pages/consultant_process.php");
  aj.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  aj.send("action=consultant_chat&chat_message=" + txt);
}

/* Consultant reply of new chat opened*/
function _chat(chat_id, user_id) {

  aj.onreadystatechange = function () {
    if (aj.readyState == 4 && aj.status == 200) {
      document.getElementById("content").innerHTML = aj.responseText;
      get_msg(chat_id, user_id);
    }
  };

  aj.open("POST", "pages/consultant_process.php");
  aj.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  aj.send("action=chat_open&chat_id=" + chat_id + "&user_id=" + user_id);
}

/* Consultant reply of new chat opened add reply to database*/
function _chat_start(c, u) {
  let txt = document.getElementById("txt").value;

  aj.onreadystatechange = function () {
    if (aj.readyState == 4 && aj.status == 200) {
      _chat(c, u);
    }
  };

  aj.open("POST", "pages/consultant_process.php");
  aj.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  aj.send("action=add_consultant_reply&chat_message=" + txt);
}

//  Comments Show particular
function _comments_permission(id) {

  aj.onreadystatechange = function () {
    if (aj.readyState == 4 && aj.status == 200) {
      document.getElementById("for_comment").innerHTML = aj.responseText;
    }
  };

  aj.open("POST", "pages/manage_comments.php");
  aj.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  aj.send("action=comment&id=" + id);
}


//  Comments Allow/Disallow
function active_comment(s, id, p_id) {

  var status = s.name;

  aj.onreadystatechange = function () {
    if (aj.readyState == 4 && aj.status == 200) {
      alert(aj.responseText);
      _comments_permission(p_id);
    }
  };

  aj.open("POST", "pages/manage_comments.php");
  aj.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  aj.send("action=comment_allow&id=" + id + "&status=" + status + "&p_id=" + p_id);
}

//  Comments Allow/Disallow
function view_profile(id) {

  aj.onreadystatechange = function () {
    if (aj.readyState == 4 && aj.status == 200) {
      document.getElementById("content").innerHTML = aj.responseText;
    }
  };

  aj.open("POST", "pages/view_profile.php");
  aj.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  aj.send("action=view_profile&id=" + id);
}


function get_msg(chat_id, user_id) {

  setInterval(function () {

    // _chat(chat_id,user_id);

    aj.onreadystatechange = function () {
      if (aj.readyState == 4 && aj.status == 200) {
        document.getElementById("show_new_messages").innerHTML = aj.responseText;
        document.getElementById("show_new_messages").scrollTop = document.getElementById("show_new_messages").scrollHeight;
      }
    };

    aj.open("POST", "pages/consultant_process.php");
    aj.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    aj.send("action=show_new_messages&chat_id=" + chat_id + "&user_id=" + user_id);

    var a = 0;
    console.log(a++);

  }, 2000);
}

/* Manage chat history*/
function chat_history() {

  aj.onreadystatechange = function () {
    if (aj.readyState == 4 && aj.status == 200) {
      alert(aj.responseText);
      document.getElementById("content").innerHTML = aj.responseText;
    }
  };

  aj.open("POST", "pages/manage_chat_history.php");
  aj.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  aj.send("action=manage_chat_history");
}

/* Add to Cart*/
function add_to_cart(id,qty) {

  if (qty == 0) {
    qty = document.getElementById("quantity").value;
  }

  aj.onreadystatechange = function () {
    if (aj.readyState == 4 && aj.status == 200) {
      alert(aj.responseText);
      // document.getElementById("content").innerHTML = aj.responseText;
    }
  };

  aj.open("POST", "pages/cart_process.php");
  aj.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  aj.send("action=add_to_cart&id="+id+"&qty="+qty);
}

/* Rating Consultant*/
function _rating_p(p_id) {

  var star = document.getElementById("stars").value;
  var msg = document.getElementById("rating_msg").value;

  aj.onreadystatechange = function () {
    if (aj.readyState == 4 && aj.status == 200) {
      alert(aj.responseText);
      window.location("index.php");
    }
  };

  aj.open("POST", "pages/e_commerce_process.php");
  aj.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  aj.send("action=product_rate&star=" + star + "&feedback=" + msg+"&p_id="+p_id);
}