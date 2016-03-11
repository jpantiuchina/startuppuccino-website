<%@ include file="../common.jsp" %>
<%--@elvariable id="project" type="com.startuppuccino.projects.Project"--%>
<%--@elvariable id="projectAccount" type="com.startuppuccino.projects.ProjectAccount"--%>
<t:page title="${project.title}" activeMenuItem="projects">


    <div class="container">

        <p style="margin-top: 30px; margin-bottom: -20px"><a href="/projects">&larr; Projects</a></p>


        <h1><c:out value="${project.title}"/></h1>

        <sec:authorize access="hasAnyRole('ROLE_USER', 'ROLE_MENTOR', 'ROLE_ADMIN')">
            <div class="pull-right" style="margin-top: -55px">
                <a href="/projects/${project.id}/edit" class="btn btn-primary" role="button">Edit</a>
            </div>
        </sec:authorize>


        <div class="row">
            <div class="col-sm-12">

                <p style="white-space: pre-line"><c:out value="${project.description}"/></p>





            </div>
            <div class="col-sm-12">

                <h3 style="">Members</h3>

                <ol>
                    <c:forEach var="account" items="${project.accounts}">
                        <li>
                            <a href="/people/${account.account.id}">
                                <c:out value="${account.account.firstName} ${account.account.lastName}"/>
                            </a>
                        </li>
                    </c:forEach>
                </ol>



                <sec:authorize access="hasAnyRole('ROLE_USER', 'ROLE_MENTOR')">

                    <c:if test="${empty projectAccount}">
                        <form:form cssClass="form-inline" action="/projects/${project.id}/join">
                            <button type="submit" class="btn btn-success">Join</button>
                        </form:form>
                    </c:if>
                    <c:if test="${not empty projectAccount}">
                        <form:form cssClass="form-inline" action="/projects/${project.id}/leave">
                            <button type="submit" class="btn btn-danger">Leave</button>
                        </form:form>
                    </c:if>

                </sec:authorize>


            </div>

        </div>




    </div>



</t:page>

