var vue1 = new Vue({
	el: "#messageinfo",
	data: {
		title: "",
		contents: ""
	},
	created: function () {
		// getdata("GetNewsCenTer", "get", {userid: localStorage.getItem("userid")}, !0, function (e) {
		// 	1 == e.success && (vue1.title = e.body.title, vue1.contents = e.body.contents)
		// }, function (e) {
		// })
	}, mounted: function () {
		mui.init({swipeBack: !1});
		mui.plusReady(function () {
			plus.webview.currentWebview()
		})
	}
});