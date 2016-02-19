package com.startuppuccino.config;

import org.springframework.context.MessageSource;
import org.springframework.context.annotation.Bean;
import org.springframework.context.annotation.Configuration;
import org.springframework.context.support.ReloadableResourceBundleMessageSource;
import org.springframework.validation.Validator;
import org.springframework.validation.beanvalidation.LocalValidatorFactoryBean;
import org.springframework.web.servlet.config.annotation.DefaultServletHandlerConfigurer;
import org.springframework.web.servlet.config.annotation.ResourceHandlerRegistry;
import org.springframework.web.servlet.config.annotation.WebMvcConfigurationSupport;
import org.springframework.web.servlet.mvc.method.annotation.RequestMappingHandlerMapping;
import org.springframework.web.servlet.view.InternalResourceViewResolver;



//@Configuration
//@EnableWebMvc
//class WebMvcConfig extends WebMvcConfigurerAdapter
@Configuration
class WebMvcConfig extends WebMvcConfigurationSupport
{


    @Override
    public RequestMappingHandlerMapping requestMappingHandlerMapping()
    {
        RequestMappingHandlerMapping requestMappingHandlerMapping = super.requestMappingHandlerMapping();
        requestMappingHandlerMapping.setUseSuffixPatternMatch(false);
        requestMappingHandlerMapping.setUseTrailingSlashMatch(false);
        return requestMappingHandlerMapping;
    }


    @Bean(name = "messageSource")
    public MessageSource messageSource()
    {
        ReloadableResourceBundleMessageSource messageSource = new ReloadableResourceBundleMessageSource();
        messageSource.setBasename("/WEB-INF/i18n/messages");
        messageSource.setCacheSeconds(5);
        return messageSource;
    }


    @Bean
    public InternalResourceViewResolver configureViewResolver()
    {
        InternalResourceViewResolver viewResolver = new InternalResourceViewResolver();
        viewResolver.setPrefix("/WEB-INF/pages/");
        viewResolver.setSuffix(".jsp");
        return viewResolver;
    }

    @Override
    public Validator getValidator()
    {
        LocalValidatorFactoryBean validator = new LocalValidatorFactoryBean();
        validator.setValidationMessageSource(messageSource());
        return validator;
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


    @Override
    public void configureDefaultServletHandling(DefaultServletHandlerConfigurer configurer)
    {
        configurer.enable();
    }
}
