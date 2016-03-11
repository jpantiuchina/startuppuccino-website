<%@ include file="../common.jsp" %>
<%--@elvariable id="projectList" type="java.util.List<com.startuppuccino.accounts.Account>"--%>
<t:page-with-header title="Projects" activeMenuItem="projects">

    <sec:authorize access="hasAnyRole('ROLE_USER', 'ROLE_MENTOR', 'ROLE_ADMIN')">
        <div class="pull-right" style="margin-top: -55px">
            <a href="/projects/add" class="btn btn-primary" role="button">Add Project</a>
        </div>
    </sec:authorize>


    <div class="row" style="margin-top: 30px">
        <%--@elvariable id="project" type="com.startuppuccino.projects.Project"--%>
        <c:forEach var="project" items="${projectList}">
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="media" style="margin-bottom:30px">
                    <div class="media-body">
                        <h4 class="media-heading">
                            <a href="/projects/${project.id}"><c:out value="${project.title}"/></a>
                        </h4>
                        <div>
                            <c:out value="${project.description}"/>
                        </div>
                    </div>
                </div>
            </div>
        </c:forEach>
    </div>






</t:page-with-header>

