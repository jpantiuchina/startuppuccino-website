package com.startuppuccino.config;

import org.springframework.web.filter.CharacterEncodingFilter;
import org.springframework.web.filter.DelegatingFilterProxy;
import org.springframework.web.servlet.support.AbstractAnnotationConfigDispatcherServletInitializer;

import javax.servlet.*;



public class WebAppInitializer extends AbstractAnnotationConfigDispatcherServletInitializer
{
    @Override
    protected String[] getServletMappings()
    {
        return new String[]{"/"};
    }


    @Override
    protected Class<?>[] getRootConfigClasses()
    {
        return new Class<?>[] {
                ApplicationConfig.class,
//                JpaConfig.class,
//                SecurityConfig.class,
                WebMvcConfig.class,
        };
    }


    @Override
    protected Class<?>[] getServletConfigClasses()
    {
        // Here I do not know what works and what does not, but this configuration seem to be
        // OK for both IDEA (shows views and controllers) and Tomcat.
        return new Class<?>[] {
                ApplicationConfig.class,
                WebMvcConfig.class,
        };
    }


    @Override
    protected Filter[] getServletFilters()
    {
        CharacterEncodingFilter characterEncodingFilter = new CharacterEncodingFilter();
        characterEncodingFilter.setEncoding("UTF-8");
        characterEncodingFilter.setForceEncoding(true);

        DelegatingFilterProxy securityFilterChain = new DelegatingFilterProxy("springSecurityFilterChain");

        return new Filter[]{characterEncodingFilter, securityFilterChain};
    }


    @Override
    protected void customizeRegistration(ServletRegistration.Dynamic registration)
    {
        int size = 10 * 1024 * 1024;
        registration.setMultipartConfig(
                new MultipartConfigElement("/tmp", (long) size, (long) size, size));
    }


//    @Override
//    protected void customizeRegistration(ServletRegistration.Dynamic registration)
//    {
//        registration.setInitParameter("defaultHtmlEscape", "true");
//        registration.setInitParameter("spring.profiles.active", "default");
//    }
}
