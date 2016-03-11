<%@ include file="../common.jsp" %>
<t:page-with-header title="${project.id != 0 ? project.title : 'New Project'}" activeMenuItem="projects">

    <t:form modelAttribute="project" submitButtonLabel="${project.id != 0 ? 'Save' : 'Create'}">

        <t:input path="title"       label="Title"                                          />
        <t:input path="description" label="Description" type="textarea" cols="60" rows="10"/>


    </t:form>


</t:page-with-header>
