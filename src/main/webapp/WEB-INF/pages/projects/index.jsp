<%@ include file="../common.jsp" %>
<%--@elvariable id="projectList" type="java.util.List<com.startuppuccino.accounts.Account>"--%>
<t:page-with-header title="Projects" activeMenuItem="projects">

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

