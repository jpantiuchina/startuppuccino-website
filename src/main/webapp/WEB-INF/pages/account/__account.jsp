<%@ include file="../common.jsp" %>

<div class="row">

    <div class="col-md-9">
        <t:form modelAttribute="account" submitButtonLabel="${param.submitButtonLabel}">

            <c:if test="${param.showEmailAndPassword}">
                <t:input path="email"      label="Email"                    />
                <t:input path="password"   label="Password" type="password" />
            </c:if>
            <t:input path="firstName"  label="First name"               />
            <t:input path="lastName"   label="Last name"                />
            <t:input path="background" label="Background" hint="e.g. IT, design, law, economics, management" />




            <t:control-group path="role" label="Role">
                <div class=radio><label><form:radiobutton path="role" value="ROLE_USER"/> User (I’m here to learn) </label></div>
                <div class=radio><label><form:radiobutton path="role" value="ROLE_MENTOR"/> Mentor (I’m here to help)      </label></div>
                <sec:authorize access="hasRole('ROLE_ADMIN')">
                    <div class=radio><label><form:radiobutton path="role" value="ROLE_ADMIN"/> Administrator</label></div>
                </sec:authorize>
            </t:control-group>


            <t:control-group path="avatar" label="Photo (optional)">
                <input type="file" name="avatar">
            </t:control-group>


        </t:form>

    </div>

    <div class="col-md-3">
        <c:if test="${account.hasAvatar}">
            <img class="img-responsive img-thumbnail" src="/people/${account.id}/avatar">
        </c:if>
    </div>



</div>


