<%@ include file="../common.jsp" %>
<t:layout-with-header title="Registration" activeMenuItem="registration">



    <t:form modelAttribute="account" submitButtonLabel="Register">

        <t:input path="email"    label="Email"                   />
        <t:input path="password" label="Password" type="password"/>



    </t:form>







</t:layout-with-header>

