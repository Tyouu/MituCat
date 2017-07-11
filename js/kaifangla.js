var app = angular.module('kaifanla', ['ng','ngRoute']);
//路由词典
app.config(function ($routeProvider) {
    $routeProvider
        .when('/Start',{templateUrl:'tpl/start.html'})
        .when('/Main',{templateUrl:'tpl/main.html',controller:'mainCtrl'})
        .when('/Detail/:did',{templateUrl:'tpl/detail.html',controller:'detailCtrl'})
        .when('/Order/:id',{templateUrl:'tpl/order.html',controller:'orderCtrl'})
        .when('/MyOrder',{templateUrl:'tpl/myOrder.html',controller:'myOrderCtrl'})
        .otherwise({redirectTo:'/Start'})
});
//实现跳转
app.controller('bodyCtrl',['$scope','$location', function ($scope, $location) {
    $scope.jump= function (routeUrl) {
        $location.path(routeUrl);
    };
}]);
//main页面处理网络请求的控制器
app.controller('mainCtrl',['$scope','$http', function ($scope, $http) {
    $scope.hasMore=true;
    //将用户输入绑定到该变量中
    $scope.kw="";
    //取得列表数据显示
    $http.get('date/dish_getbypage.php')
        .success(function (data) {
            console.log(data);
            $scope.dishList=data;
        }
    );
    //加载更多
    $scope.loadMore= function () {
        $http.get('date/dish_getbypage.php?start='+ $scope.dishList.length)
            .success(function (data) {
                if(data.length<5){
                    //没有更多数据
                    $scope.hasMore=false;
                }
                $scope.dishList=$scope.dishList.concat(data);
            })
    };
    //根据用户输入的值,搜索
    $scope.$watch('kw', function () {
        if($scope.kw.length>0){
            //发起网络请求 dish_getbykw.php
            $http
                .get('date/dish_getbykw.php?kw='+$scope.kw)
                .success(function (data) {
                    console.log(data);
                    if(data.length>0){
                        $scope.dishList=data;
                    }
                })
        }
    });
}]);
//detail传参
app.controller('detailCtrl', ['$scope', '$routeParams', '$http', function ($scope, $routeParams, $http) {
    $http
        .get('date/dish_getbyid.php?did=' + $routeParams.did)
        .success(function (data) {
            console.log(data);
            $scope.dish = data[0];
        })

}]);
//order接参传参
app.controller('orderCtrl',
    ['$scope', '$routeParams', '$http','$httpParamSerializerJQLike',
        function ($scope, $routeParams,$http, $httpParamSerializerJQLike) {
            console.log($routeParams);
            $scope.order = {
                user_name: '',
                sex: 1,
                phone: '',
                addr: '',
                did: $routeParams.id
            };
            //$httpParamSerializerJQLike()
            $scope.submitOrder = function () {
                //得到当前用户输入的信息
                console.log($scope.order);
                var result = $httpParamSerializerJQLike($scope.order);
                console.log(result);
                //将数据发给服务器
                $http.get('date/order_add.php?' + result)
                    .success(function (data) {
                        console.log(data);
                        if(data.msg == 'success')
                        {
                            $scope.orderResult = "下单成功，订单编号为"+data.oid;
                            sessionStorage.setItem('phone',$scope.order.phone)
                        }
                        else
                        {
                            $scope.orderResult = "下单失败";
                        }
                    })
            }
        }]);
//个人订单页控制器
app.controller('myOrderCtrl',['$scope','$http', function ($scope, $http) {
    //获取存在本地的手机号
    var userPhone=sessionStorage.getItem('phone');
    console.log(userPhone);
    //发起wan网络请求获取该手机号对应的订单信息
    $http.get('date/order_getbyphone.php?phone='+userPhone)
        .success(function (data) {
            console.log(data);
            //拿到对象数组之后绑定到视图
            $scope.orderList=data;
        })
}]);