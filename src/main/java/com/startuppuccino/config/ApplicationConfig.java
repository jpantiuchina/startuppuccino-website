package com.startuppuccino.config;

import org.springframework.context.annotation.Bean;
import org.springframework.context.annotation.ComponentScan;
import org.springframework.context.annotation.Configuration;
import org.springframework.context.annotation.PropertySource;
import org.springframework.context.support.PropertySourcesPlaceholderConfigurer;

import com.startuppuccino.Application;
import org.springframework.web.multipart.MultipartResolver;
import org.springframework.web.multipart.support.StandardServletMultipartResolver;



@Configuration
@PropertySource("classpath:persistence.properties")
@ComponentScan(basePackageClasses = Application.class)
class ApplicationConfig
{
    /**
     * Enable @Value annotation support
     *
     * http://stackoverflow.com/questions/13728000/
     */
    @Bean
    public static PropertySourcesPlaceholderConfigurer propertySourcesPlaceholderConfigurer()
    {
        return new PropertySourcesPlaceholderConfigurer();
    }
}
