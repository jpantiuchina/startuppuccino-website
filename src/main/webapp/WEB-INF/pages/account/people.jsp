<%@ include file="../common.jsp" %>
<%--@elvariable id="accounts" type="java.util.List<com.startuppuccino.account.Account>"--%>
<t:page-with-header title="People" activeMenuItem="people">


    <c:forEach var="account" items="${accounts}">

        <div class="media" id="comment-${account.id}">
            <div class="media-left">
                <div style="width: 64px !important; max-height: 64px !important">
                    <c:if test="${account.hasAvatar}">
                        <a href="/people/${account.id}">
                            <img class="media-object img-responsive" src="/people/${account.id}/avatar">
                        </a>
                    </c:if>
                </div>
            </div>
            <div class="media-body">
                <h4 class="media-heading">
                    <a href="/people/${account.id}"><c:out value="${account.firstName} ${account.lastName}"/></a>
                </h4>
                <c:choose>
                    <c:when test="${account.isMentor}">
                        <div><span class="label label-primary">Mentor</span></div>
                    </c:when>
                </c:choose>
                <div>
                    <c:out value="${account.background}"/>
                </div>
            </div>
        </div>

    </c:forEach>






</t:page-with-header>

