<%@ include file="../common.jsp" %>
<t:page-with-header title="Login" activeMenuItem="login">


    <form:form action="/login" method="post" cssClass="form-horizontal">
        <c:if test="${param.error != null}">
            <div class="alert alert-danger">
                Invalid username or password.
            </div>
        </c:if>
        <c:if test="${param.logout != null}">
            <div class="alert alert-success">
              <strong>You have been logged out.</strong>
            </div>
        </c:if>

        <div class="form-group">
            <label for="username" class="col-lg-2 control-label">Email</label>
            <div class="col-lg-10">
                <input type="text" class="form-control" id="username" name="username" autofocus />
            </div>
        </div>
        <div class="form-group">
            <label for="password" class="col-lg-2 control-label">Password</label>
            <div class="col-lg-10">
                <input type="password" class="form-control" id="password" name="password" />
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-offset-2 col-lg-10">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="remember-me"> Remember me
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-offset-2 col-lg-10">
                <button type="submit" class="btn btn-primary">Login</button>
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-offset-2 col-lg-10">
                <p>New here? <a href="/registration">Register</a></p>
            </div>
        </div>

    </form:form>


</t:page-with-header>

