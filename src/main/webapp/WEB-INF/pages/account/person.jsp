<%@ include file="../common.jsp" %>
<%--@elvariable id="account" type="com.startuppuccino.account.Account"--%>
<t:page title="${account.firstName} ${account.lastName}" activeMenuItem="people">


    <div class="container">
        <p><a href="/people">&larr; People</a></p>


        <h1><c:out value="${account.firstName} ${account.lastName}"/></h1>


        <div class="row">
            <div class="col-sm-6">
                <c:choose>
                    <c:when test="${account.isMentor}">
                        <div><span class="label label-primary">Mentor</span></div>
                    </c:when>
                    <c:when test="${account.isUser}">
                        <div><span class="label label-info">User</span></div>
                    </c:when>
                    <c:when test="${account.isMentor}">
                        <div><span class="label label-warning">Admin</span></div>
                    </c:when>
                </c:choose>
                <div>
                    <c:out value="${account.background}"/>
                </div>


            </div>
            <div class="col-sm-6">
                <c:if test="${account.hasAvatar}">
                    <img src="/people/${account.id}/avatar" class="img-responsive img-thumbnail" alt="">
                </c:if>
            </div>

        </div>




    </div>



</t:page>

