<%@ include file="../common.jsp" %>
<t:page-with-header title="Registration" activeMenuItem="registration">

    <jsp:include page="__account.jsp">
        <jsp:param name="submitButtonLabel" value="Register"/>
        <jsp:param name="showEmailAndPassword" value="true"/>

    </jsp:include>

</t:page-with-header>
