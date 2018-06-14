var pageno1 = 1, pageno2 = 1, pageno3 = 1, pageno4 = 1, pageno5 = 1, pageno6 = 1, pageno7 = 1, vue1 = new Vue({
	el: "#bill",
	data: {
		type: [],
		list1: [],
		list2: [],
		list3: [],
		list4: [],
		list5: [],
		list6: [],
		list7: [],
		count1: 0,
		count2: 0,
		count3: 0,
		count4: 0,
		count5: 0,
		count6: 0,
		count7: 0,
		common: "0.00",
		progress: ""
	},
	created: function () {
		// getdata("GetBill", "get", {userid: localStorage.getItem("userid"), type: "0", pageno: 1}, !0, function (e) {
		// 	1 == e.success ? (vue1.list1 = e.body.paging, vue1.common = e.body.common, vue1.count1 = e.body.pageCount) : mui.toast(e.msg)
		// }, function (e) {
		// })
	},
	mounted: function () {
	
	},
	methods: {
		shuaxin: function (e, t, u) {
			// getdata("GetBill", "get", {userid: e, type: t, pageno: u}, !0, function (e) {
			// 	1 == e.success ? (vue1["list" + (t + 1)] = e.body.paging, vue1["count" + (t + 1)] = e.body.pageCount) : mui.toast(e.msg)
			// })
		},
		getlist: function (e, t) {
			this[e].length > 0 || getdata("GetBill", "get", {
				userid: localStorage.getItem("userid"),
				type: t,
				pageno: 1
			}, !0, function (u) {
				1 == u.success ? (vue1[e] = u.body.paging, vue1["count" + (t + 1)] = u.body.pageCount) : mui.toast(u.msg)
			}, function (e) {
			})
		}, getnewpage: function (e, t, u) {
			var n = Number(t) + 1;
			// getdata("GetBill", "get", {userid: e, type: t, pageno: u}, !0, function (e) {
			// 	1 == e.success ? vue1["list" + n].length > 0 && $.each(e.body.paging, function (e, t) {
			// 		vue1["list" + n].push(t)
			// 	}) : mui.toast(e.msg)
			// }, function (e) {
			// })
		}, loadmore: function (e) {
		}
	}
});
Vue.filter("sign", function (e) {
	return e > 0 ? "+" + e : e
});