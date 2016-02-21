<%@ include file="../common.jsp" %>
<t:page-with-header title="Account ${account.email}" activeMenuItem="account">

    <%--@elvariable id="showSavedSuccessfullyMessage" type="java.lang.Boolean"--%>

    <c:if test="${showSavedSuccessfullyMessage}">
        <div class="alert alert-success">
            <strong>Success!</strong> The changes have been saved.
        </div>
    </c:if>

    <jsp:include page="__account.jsp">
        <jsp:param name="submitButtonLabel" value="Save"/>
        <jsp:param name="showEmailAndPassword" value="false"/>
    </jsp:include>

</t:page-with-header>
