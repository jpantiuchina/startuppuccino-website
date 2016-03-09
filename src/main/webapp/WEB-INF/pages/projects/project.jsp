<%@ include file="../common.jsp" %>
<%--@elvariable id="project" type="com.startuppuccino.projects.Project"--%>
<t:page title="${project.title}" activeMenuItem="projects">


    <div class="container">

        <p style="margin-top: 30px; margin-bottom: -20px"><a href="/projects">&larr; Projects</a></p>


        <h1><c:out value="${project.title}"/></h1>


        <div class="row">
            <div class="col-sm-6">

                <p style="white-space: pre-line"><c:out value="${project.description}"/></p>


            </div>
            <div class="col-sm-6">

                <sec:authorize access="hasAnyRole('ROLE_USER', 'ROLE_MENTOR')">
                    <form:form cssClass="form-inline" action="/projects/${project.id}/join">
                        <button type="submit" class="btn btn-primary">Join</button>
                    </form:form>
                </sec:authorize>


            </div>

        </div>




    </div>



</t:page>

