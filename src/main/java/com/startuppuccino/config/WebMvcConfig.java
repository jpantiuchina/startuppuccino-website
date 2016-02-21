package com.startuppuccino.config;

import org.springframework.context.annotation.Bean;
import org.springframework.context.annotation.Configuration;
import org.springframework.web.multipart.MultipartResolver;
import org.springframework.web.multipart.support.StandardServletMultipartResolver;
import org.springframework.web.servlet.ViewResolver;
import org.springframework.web.servlet.config.annotation.DefaultServletHandlerConfigurer;
import org.springframework.web.servlet.config.annotation.EnableWebMvc;
import org.springframework.web.servlet.config.annotation.ResourceHandlerRegistry;
import org.springframework.web.servlet.config.annotation.ViewResolverRegistry;
import org.springframework.web.servlet.config.annotation.WebMvcConfigurationSupport;
import org.springframework.web.servlet.config.annotation.WebMvcConfigurerAdapter;
import org.springframework.web.servlet.mvc.method.annotation.RequestMappingHandlerMapping;
import org.springframework.web.servlet.view.InternalResourceViewResolver;



@Configuration
@EnableWebMvc
class WebMvcConfig extends WebMvcConfigurerAdapter
{
    @Override
    public void configureViewResolvers(ViewResolverRegistry registry)
    {
        registry.jsp("/WEB-INF/pages/", ".jsp");
    }


    @Bean(name = "filterMultipartResolver")
    public MultipartResolver filterMultipartResolver()
    {
        return new StandardServletMultipartResolver();
    }




    @Override
    public void addResourceHandlers(ResourceHandlerRegistry registry)
    {
        registry.addResourceHandler("/favicon.ico").
                addResourceLocations("/resources/");
        registry.addResourceHandler("/resources/bootstrap/**").
                addResourceLocations("classpath:/META-INF/resources/webjars/bootstrap/");
        registry.addResourceHandler("/resources/jquery/**").
                addResourceLocations("classpath:/META-INF/resources/webjars/jquery/");
        registry.addResourceHandler("/resources/**").
                addResourceLocations("/resources/");
    }


//    @Override
//    public void configureDefaultServletHandling(DefaultServletHandlerConfigurer configurer)
//    {
//        configurer.enable();
//    }
}
