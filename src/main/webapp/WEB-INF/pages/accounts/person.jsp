<%@ include file="../common.jsp" %>
<%--@elvariable id="account" type="com.startuppuccino.accounts.Account"--%>
<t:page title="${account.firstName} ${account.lastName}" activeMenuItem="people">


    <div class="container">

        <p style="margin-top: 30px; margin-bottom: -20px"><a href="/people">&larr; People</a></p>


        <h1><c:out value="${account.firstName} ${account.lastName}"/></h1>


        <div class="row">
            <div class="col-sm-6">
                <c:choose>
                    <c:when test="${account.isMentor}">
                        <p><span class="label label-primary">Mentor</span></p>
                    </c:when>
                    <c:when test="${account.isUser}">
                        <p><span class="label label-info">User</span></p>
                    </c:when>
                    <c:when test="${account.isMentor}">
                        <p><span class="label label-warning">Admin</span></p>
                    </c:when>
                </c:choose>

                <p style="font-weight: bold">
                    <c:out value="${account.background}"/>
                </p>

                <sec:authorize access="isAuthenticated()">
                    <p><a href="mailto:<c:out value="${account.email}"/>"><c:out value="${account.email}"/></a></p>
                </sec:authorize>





                <p style="white-space: pre-line"><c:out value="${account.about}"/></p>


            </div>
            <div class="col-sm-6">
                <c:if test="${account.hasAvatar}">
                    <img src="/people/${account.id}/avatar" class="img-responsive img-thumbnail" alt="">
                </c:if>
            </div>

        </div>




    </div>



</t:page>

