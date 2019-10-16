$(function() {
  //編集ボタンを押したとき
  $(".editItem").on("click", function() {
    var parent = $(this)
      .parent()
      .parent();
    parent.find("input").show();
    parent.find("span").hide();
    parent.find(".saveItem").show();
    $(this).hide();
  });

  //保存ボタンを押したとき
  $(".saveItem").on("click", function() {
    var parent = $(this)
      .parent()
      .parent();
    var id = $(this).attr("itemno");
    var title = parent.find(".title").val();
    var number = parent.find(".number").val();
    var tag_1 = parent.find(".tag_1").val();
    var tag_2 = parent.find(".tag_2").val();
    var action = "save_edit";
    if (title == "") {
      alert("タイトルが入力されていません");
      return;
    }
    if (number == "") {
      alert("巻数が入力されていません");
      return;
    }
    $.ajax({
      url: "save_edit.php",
      data: {
        id: id,
        title: title,
        number: number,
        tag_1: tag_1,
        tag_2: tag_2,
        action: action
      },
      method: "post",
      success: function(data) {
        alert("編集完了");
        location.reload();
      }
    });
  });

  //削除ボタンを押したとき
  $(".deleteItem").on("click", function() {
    if (confirm("本当に削除しますか？")) {
      var id = $(this).attr("itemno");
      var action = "delete_item";
      $.ajax({
        url: "delete_edit.php",
        method: "post",
        data: {
          id: id,
          action: action
        },
        success: function(date) {
          alert("削除完了");
          location.reload();
        }
      });
    }
  });

  //minusボタンを押したとき
  $(".minus").on("click", function() {
    var id = $(this).attr("itemno");
    var action = "minus_item";
    $.ajax({
      url: "number_edit.php",
      method: "post",
      data: {
        id: id,
        action: action
      },
      success: function(date) {
        location.reload();
      }
    });
  });

  //plusボタンを押したとき
  $(".plus").on("click", function() {
    var id = $(this).attr("itemno");
    var action = "plus_item";
    $.ajax({
      url: "number_edit.php",
      method: "post",
      data: {
        id: id,
        action: action
      },
      success: function(date) {
        location.reload();
      }
    });
  });
});
