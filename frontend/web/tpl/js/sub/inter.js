var pageNo1 = 1, pageNo2 = 1, template = null, subWebview = null, home = null, yztime = 60, vue1 = new Vue({
	el: "#guonei",
	data: {
		nowprice: 1e-4,
		total: 1e-4,
		range: 200,
		list: [],
		list2: [],
		count1: 0,
		tradeinfo: {accountName: "", openingBank: "", cardNumber: "", weixin: "", alipay: "", tel: "", state: ""},
		count2: 0,
		buybtn: !1,
		address: "",
		ytwallet: ""
	},
	created: function () {
		// getmarketdata("GetMyHangTranZone", "get", {
		// 	userid: localStorage.getItem("userid"),
		// 	pageno: 1,
		// 	type: "0"
		// }, !0, function (e) {
		// 	1 == e.success && (vue1.list = e.body.paging, vue1.count1 = e.body.pageCount, "True" == e.body.two && (vue1.buybtn = !0))
		// }, function (e) {
		// })
	},
	computed: {
		totalprice: function () {
			return parseFloat((this.range * this.total).toFixed(4))
		}
	},
	methods: {
		limitsmall: function () {
			this.total < 0 ? this.total = 1e-4 : 0 == this.total ? this.total = 1e-4 : this.total = 1e4 * this.total / 1e4
		}, limitzero: function () {
			this.total <= 0 && (this.total = 1e-4)
		}, addnum: function () {
			var e = 1e4 * this.total;
			e = Math.ceil(e + 1), vue1.total = e / 1e4
		}, reducenum: function () {
			this.total <= 1e-4 ? mui.toast("不允许小于0.0001") : this.total = Math.floor(1e4 * this.total - 1) / 1e4
		}, ortitle: function (e) {
			return -1 == e ? "卖家资料" : "买家资料"
		}, lookinfo: function (e) {
			getdata("GetTranWallet", "get", {userid: localStorage.getItem("userid"), tranid: e.id}, !0, function (e) {
				1 == e.success && (0 == e.body.length || (vue1.address = e.body[0].address, vue1.ytwallet = e.body[0].name))
			}, function (e) {
			}), vue1.tradeinfo = {
				accountName: e.pushAccountName,
				openingBank: e.pushBank,
				cardNumber: e.pushCard,
				tel: e.pushTel,
				alipay: e.pushAlipay,
				weixin: e.pushWeixin,
				state: e.state
			}, mui("#popover").popover("show")
		}, closeinfo: function () {
			mui("#popover").popover("hide")
		},
		// confirmtrade: function (e, t, a, i) {
		// 	if (i.detail.gesture.preventDefault(), "0" == localStorage.getItem("isPass")) mui.fire(template, "updateHeader", {
		// 		title: "设置交易密码",
		// 		href: "../sub/setpaypass.html"
		// 	}), "../sub/setpaypass.html" == subWebview.getURL() ? subWebview.show() : (subWebview.loadURL("../sub/setpaypass.html"), subWebview.addEventListener("loaded", function () {
		// 		setTimeout(function () {
		// 			subWebview.show()
		// 		}, 50)
		// 	})), template.show("slide-in-right", 150); else {
		// 		var o = ["确定", "取消"];
		// 		3 == a ? (mui.prompt("请严格按照平台公布卖家资料进行打款，请勿相信中介！", "交易密码", "请输入交易密码", o, function (e) {
		// 			0 == e.index && getdata("CheckPayPass", "get", {
		// 				userid: localStorage.getItem("userid"),
		// 				paypass: e.value
		// 			}, !0, function (i) {
		// 				if (1 == i.success) if (60 == yztime) {
		// 					var s = setInterval(function () {
		// 						--yztime < 0 && (clearInterval(s), yztime = 60)
		// 					}, 1e3);
		// 					getmarketdata("IsHandCode", "get", {
		// 						userid: localStorage.getItem("userid"),
		// 						tranid: t
		// 					}, !0, function (i) {
		// 						1 == i.success ? 0 != i.body ? (mui.toast(i.msg), mui.prompt("请输入短信验证码：", "短信验证码", "请输入验证码", o, function (i) {
		// 							0 == i.index && getmarketdata("HandleTranNew", "get", {
		// 								userid: localStorage.getItem("userid"),
		// 								step: a,
		// 								tranid: t,
		// 								paypass: e.value,
		// 								code: i.value
		// 							}, !0, function (e) {
		// 								1 == e.success ? (mui.toast(e.msg), mui.fire(home, "updateVrc"), location.reload()) : mui.toast(e.msg)
		// 							}, function (e) {
		// 							})
		// 						})) : getmarketdata("HandleTranNew", "get", {
		// 							userid: localStorage.getItem("userid"),
		// 							step: a,
		// 							tranid: t,
		// 							paypass: e.value,
		// 							code: "a"
		// 						}, !0, function (e) {
		// 							1 == e.success ? (mui.toast(e.msg), mui.fire(home, "updateVrc"), location.reload()) : mui.toast(e.msg)
		// 						}, function (e) {
		// 						}) : mui.toast(i.msg)
		// 					}, function (e) {
		// 					})
		// 				} else mui.toast(yztime + "s后才能获取验证码"); else mui.toast(i.msg)
		// 			}, function (e) {
		// 			})
		// 		}, "div"), document.querySelector(".mui-popup-input input").type = "password") : (mui.prompt("请严格按照平台公布卖家资料进行打款，请勿相信中介！", "交易密码", "请输入交易密码", o, function (e) {
		// 			0 == e.index && getdata("CheckPayPass", "get", {
		// 				userid: localStorage.getItem("userid"),
		// 				paypass: e.value
		// 			}, !0, function (i) {
		// 				1 == i.success ? getmarketdata("HandleTranNew", "get", {
		// 					userid: localStorage.getItem("userid"),
		// 					step: a,
		// 					tranid: t,
		// 					paypass: e.value,
		// 					code: "a"
		// 				}, !0, function (e) {
		// 					1 == e.success ? (mui.toast(e.msg), mui.fire(home, "updateVrc"), location.reload()) : mui.toast(e.msg)
		// 				}, function (e) {
		// 				}) : mui.toast(i.msg)
		// 			})
		// 		}, "div"), document.querySelector(".mui-popup-input input").type = "password")
		// 	}
		// }, confirmtrade2: function (e, t, a) {
		// 	if (a.detail.gesture.preventDefault(), "0" == localStorage.getItem("isPass")) mui.fire(template, "updateHeader", {
		// 		title: "设置交易密码",
		// 		href: "../sub/setpaypass.html"
		// 	}), "../sub/setpaypass.html" == subWebview.getURL() ? subWebview.show() : (subWebview.loadURL("../sub/setpaypass.html"), subWebview.addEventListener("loaded", function () {
		// 		setTimeout(function () {
		// 			subWebview.show()
		// 		}, 50)
		// 	})), template.show("slide-in-right", 150); else {
		// 		var i = ["确定", "取消"];
		// 		getdata("GetWallet", "get", {userid: localStorage.getItem("userid")}, !0, function (t) {
		// 			1 == t.success && (0 == t.body.length ? (mui.fire(template, "updateHeader", {
		// 				title: "虚拟钱包",
		// 				href: "../sub/ethpurse.html"
		// 			}), "../sub/ethpurse.html" == subWebview.getURL() ? subWebview.show() : (subWebview.loadURL("../sub/ethpurse.html"), subWebview.addEventListener("loaded", function () {
		// 				setTimeout(function () {
		// 					subWebview.show()
		// 				}, 50)
		// 			})), template.show("slide-in-right", 150)) : (mui.prompt("请严格按照平台公布卖家资料进行打款，请勿相信中介！", "交易密码", "请输入交易密码", i, function (t) {
		// 				0 == t.index && getdata("CheckPayPass", "get", {
		// 					userid: localStorage.getItem("userid"),
		// 					paypass: t.value
		// 				}, !0, function (a) {
		// 					if (1 == a.success) if (60 == yztime) {
		// 						var o = setInterval(function () {
		// 							--yztime < 0 && (clearInterval(o), yztime = 60)
		// 						}, 1e3);
		// 						getmarketdata("IsHandCodeOne", "get", {
		// 							userid: localStorage.getItem("userid"),
		// 							tranid: e,
		// 							amount: 0,
		// 							trantype: 3
		// 						}, !0, function (a) {
		// 							1 == a.success ? 0 != a.body ? (mui.toast(a.msg), mui.prompt("请输入短信验证码：", "短信验证码", "请输入验证码", i, function (a) {
		// 								0 == a.index && getmarketdata("HangTransferByCode", "get", {
		// 									userid: localStorage.getItem("userid"),
		// 									tranid: e,
		// 									paypass: t.value,
		// 									code: a.value
		// 								}, !0, function (e) {
		// 									1 == e.success ? (mui.toast(e.msg), mui.fire(home, "updateVrc"), location.reload()) : mui.toast(e.msg)
		// 								}, function (e) {
		// 								})
		// 							})) : getmarketdata("HangTransferByCode", "get", {
		// 								userid: localStorage.getItem("userid"),
		// 								tranid: e,
		// 								paypass: t.value,
		// 								code: "a"
		// 							}, !0, function (e) {
		// 								1 == e.success ? (mui.toast(e.msg), mui.fire(home, "updateVrc"), location.reload()) : mui.toast(e.msg)
		// 							}, function (e) {
		// 							}) : mui.toast(a.msg)
		// 						}, function (e) {
		// 						})
		// 					} else mui.toast(yztime + "s后才能获取验证码"); else mui.toast(a.msg)
		// 				}, function (e) {
		// 				})
		// 			}, "div"), document.querySelector(".mui-popup-input input").type = "password"))
		// 		}, function (e) {
		// 		})
		// 	}
		// }, esctrade: function (e, t) {
		// 	mui.confirm("确认取消吗？", "取消交易", ["确认", "取消"], function (a) {
		// 		0 == a.index && getmarketdata("HandleTranNew", "get", {
		// 			userid: localStorage.getItem("userid"),
		// 			step: t,
		// 			tranid: e,
		// 			paypass: "a",
		// 			code: "a"
		// 		}, !0, function (e) {
		// 			1 == e.success ? (mui.toast(e.msg), location.reload()) : mui.toast(e.msg)
		// 		}, function (e) {
		// 		})
		// 	})
		// }, checkNumber: function (e) {
		// 	e < 200 ? this.range = 200 : e > 5e3 && (this.range = 5e3)
		// }, limitbig: function (e) {
		// 	e > 200 && e % 10 != 0 ? (mui.toast("请输入10的倍数"), this.range = e - e % 10) : e > 5e3 && (this.range = 5e3)
		// }, buythis: function () {
		// 	return this.range < 10 ? (this.range = 10, void mui.toast("最小为10")) : this.range > 6250 ? (this.range = 6250, void mui.toast("最大为6250")) : void mui.toast("交易成功")
		// }, getnewpage: function (e, t) {
		// 	0 == e ? getmarketdata("GetMyHangTranZone", "get", {
		// 		userid: localStorage.getItem("userid"),
		// 		pageno: t,
		// 		type: e
		// 	}, !0, function (e) {
		// 		1 == e.success && ("True" == e.body.two && (vue1.buybtn = !0), $.each(e.body.paging, function (e, t) {
		// 			vue1.list.push(t)
		// 		}))
		// 	}, function (e) {
		// 	}) : getmarketdata("GetMyHangTranZone", "get", {
		// 		userid: localStorage.getItem("userid"),
		// 		pageno: t,
		// 		type: e
		// 	}, !0, function (e) {
		// 		1 == e.success && ("True" == e.body.two && (vue1.buybtn = !0), $.each(e.body.paging, function (e, t) {
		// 			vue1.list2.push(t)
		// 		}))
		// 	}, function (e) {
		// 	})
		// }
	},
	mounted: function () {
		mui.init({swipeBack: !1}), mui.plusReady(function () {
			template = plus.webview.getWebviewById("template_second"), subWebview = plus.webview.getWebviewById("sub_template_second"), home = plus.webview.getWebviewById("barItem/mine.html"), new Clipboard(".copy"), mui(".mui-scroll-wrapper").scroll({
				bounce: !0,
				indicators: !1,
				deceleration: mui.os.ios ? .003 : 9e-4
			}), mui("#scroll3").pullRefresh({
				up: {
					height: 100,
					auto: !1,
					contentrefresh: "正在加载...",
					contentnomore: "",
					callback: function () {
						var e = this;
						setTimeout(function () {
							e.endPullupToRefresh(vue1.count1 <= ++pageNo1), vue1.count1 <= pageNo1 && mui.toast("没有更多了"), vue1.getnewpage("0", pageNo1)
						}, 150)
					}
				}
			}), mui("#scroll4").pullRefresh({
				up: {
					height: 100,
					auto: !1,
					contentrefresh: "正在加载...",
					contentnomore: "",
					callback: function () {
						var e = this;
						setTimeout(function () {
							e.endPullupToRefresh(vue1.count2 <= ++pageNo2), vue1.count2 <= pageNo2 && mui.toast("没有更多了"), vue1.getnewpage("1", pageNo2)
						}, 150)
					}
				}
			}), mui("#guonei").on("tap", ".guabuy", function () {
				if (vue1.total < 1e-4) return vue1.total = 1e-4, void mui.toast("最小为0.0001");
				if (vue1.range < 200) return vue1.range = 200, void mui.toast("最小为200");
				if (vue1.range > 5e3) return vue1.range = 5e3, void mui.toast("最大为5000");
				mui.confirm("确认挂单吗？", "确认挂单", ["确认", "取消"], function (e) {
					0 == e.index && getmarketdata("StartHangTransferZone", "get", {
						userid: localStorage.getItem("userid"),
						amount: vue1.range,
						price: vue1.total
					}, !0, function (e) {
						1 == e.success ? (mui.toast(e.msg), setTimeout(function () {
							location.reload()
						}, 150)) : mui.toast(e.msg)
					}, function (e) {
					})
				})
			}), mui(".xuzhi").on("tap", "a", function () {
				var e = this.getAttribute("data-title");
				mui.fire(template, "updateHeader", {
					title: e,
					href: this.href
				}), subWebview.getURL() == this.href ? subWebview.show() : (subWebview.loadURL(this.href), subWebview.addEventListener("loaded", function () {
					setTimeout(function () {
						subWebview.show()
					}, 50)
				})), template.show("slide-in-right", 150)
			}), mui(".tapbox2").on("tap", "li", function () {
				var e = this.getAttribute("data-index");
				"show4" == e && (vue1.list2.length > 0 || 0 == vue1.list2.length && getmarketdata("GetMyHangTranZone", "get", {
					userid: localStorage.getItem("userid"),
					pageno: 1,
					type: "1"
				}, !0, function (e) {
					1 == e.success && (vue1.list2 = e.body.paging, vue1.count2 = e.body.pageCount)
				}, function (e) {
				}));
				var t = $("#" + e);
				$(".tapbox2 li").removeClass("tapactive"), this.classList.add("tapactive"), $(".showbox2 li").removeClass("showactive"), t.addClass("showactive")
			}), mui("#guonei").on("tap", ".shuaxin", function () {
				mui.toast("已刷新"), $(".shuaxin span").css({
					"-webkit-transform": "rotate(360deg)",
					"-moz-transform": "rotate(360deg)",
					"-o-transform": "rotate(360deg)",
					"-ms-transform": "rotate(360deg)"
				}), setTimeout(function () {
					location.reload()
				}, 500)
			})
		})
	}
});