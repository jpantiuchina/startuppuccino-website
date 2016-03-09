package com.startuppuccino.config;

import org.springframework.context.annotation.Configuration;
import org.springframework.web.servlet.config.annotation.EnableWebMvc;
import org.springframework.web.servlet.config.annotation.ResourceHandlerRegistry;
import org.springframework.web.servlet.config.annotation.ViewResolverRegistry;
import org.springframework.web.servlet.config.annotation.WebMvcConfigurerAdapter;
import org.springframework.web.servlet.mvc.method.annotation.RequestMappingHandlerMapping;



@Configuration
@EnableWebMvc
class WebMvcConfig extends WebMvcConfigurerAdapter
{
    @Override
    public void configureViewResolvers(ViewResolverRegistry registry)
    {
        registry.jsp("/WEB-INF/pages/", ".jsp");
    }


    @Override
    public void addResourceHandlers(ResourceHandlerRegistry registry)
    {
        registry.addResourceHandler("/favicon.ico").
                addResourceLocations("/resources/").setCachePeriod(300);
        registry.addResourceHandler("/resources/bootstrap/**").
                addResourceLocations("classpath:/META-INF/resources/webjars/bootstrap/").setCachePeriod(9999);
        registry.addResourceHandler("/resources/jquery/**").
                addResourceLocations("classpath:/META-INF/resources/webjars/jquery/").setCachePeriod(9999);
        registry.addResourceHandler("/resources/**").
                addResourceLocations("/resources/").setCachePeriod(300);
    }



//    @Override
//    public RequestMappingHandlerMapping requestMappingHandlerMapping()
//    {
//        RequestMappingHandlerMapping requestMappingHandlerMapping = super.requestMappingHandlerMapping();
//        requestMappingHandlerMapping.setUseSuffixPatternMatch(false);
//        requestMappingHandlerMapping.setUseTrailingSlashMatch(false);
//        return requestMappingHandlerMapping;
//    }
//    @Override
//    public void configureDefaultServletHandling(DefaultServletHandlerConfigurer configurer)
//    {
//        configurer.enable();
//    }
}
